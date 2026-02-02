# Fix for Resident Street and House Number Update Issue

## Problem
When trying to update a resident's street and house number from the profile page, Laravel threw the following error:
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'houseNo' in 'field list'
```

This occurred because the `residents` table had the `houseNo` and `street` columns dropped in migration `2026_01_28_215606_drop_column_streets_house_no.php`, but the update logic was still trying to write to these non-existent columns.

## Root Cause
The database schema was redesigned to use a many-to-many relationship through the `household_resident` pivot table and `household` table, which references the `house` and `street` tables. However, the profile update functionality was not updated to use this new relationship structure.

## Solution

### 1. **Model Updates**
- **[Resident.php](app/Models/Resident.php)**: Removed `houseNo` and `street` from the `$fillable` array since these fields no longer exist in the residents table.

### 2. **Controller Updates**

#### [ResidentListController.php](app/Http/Controllers/ResidentListController.php)
- Updated `updateOwnInfo()` method to:
  - Accept `house_id` instead of `houseNo` and `street`
  - Create/update the `household` record with the selected house
  - Create/update the `household_resident` pivot record
  - Set `is_household_head` based on the `headOfFamily` field
  - Removed attempt to update non-existent `houseNo` and `street` columns

#### [ResidentController.php](app/Http/Controllers/ResidentController.php)
- Updated `updateOwnInfo()` method to use the new household relationship
- Added necessary imports: `House`, `Street`, `Household`, `HouseholdResident`
- Changed validation to require `house_id` instead of `houseNo` and `street`
- Updated to manage household assignments via the pivot table

#### [SubAdminController.php](app/Http/Controllers/SubAdminController.php)
- Updated `updateOwnInfo()` method to use the new household relationship
- Added necessary imports: `House`, `Street`, `Household`, `HouseholdResident`
- Changed validation to require `house_id` instead of `houseNo` and `street`
- Updated to manage household assignments via the pivot table

#### [AdminController.php](app/Http/Controllers/AdminController.php)
- Updated `profile()` method to eager-load household, house, and street relationships
- Changed from: `Resident::where(...)->first()`
- Changed to: `Resident::with('households.house.street')->where(...)->first()`

### 3. **View Updates**

#### [editresident.blade.php](resources/views/profileforms/editresident.blade.php)
- Replaced text input fields with dropdown selects for Street and House No.
- Added PHP logic to:
  - Extract current house from resident's households relationship
  - Get current street_id and house_id
  - Pre-select current values in the dropdowns
- Updated JavaScript to:
  - Use house IDs for comparison instead of house numbers
  - Properly populate house dropdown based on selected street
  - Pre-select current house when form loads

#### [admin/profile.blade.php](resources/views/admin/profile.blade.php)
- Updated Address display to retrieve house and street from the relationship:
  - From: `{{ $resident->houseNo }} {{ $resident->street }}`
  - To: `{{ $house->house_no }} {{ $street->street_name }}` (from relationship)

#### [resident/profile.blade.php](resources/views/resident/profile.blade.php)
- Updated Address display to retrieve house and street from the relationship

#### [subadmin/profile.blade.php](resources/views/subadmin/profile.blade.php)
- Updated Address display to retrieve house and street from the relationship

## How It Works Now

1. User opens Edit Resident Information modal
2. Form displays Street and House Number as dropdown selects
3. Current values are pre-selected based on the resident's household assignment
4. When user changes the street, the house dropdown updates dynamically
5. On form submission:
   - `house_id` is sent to the server
   - System finds/creates the appropriate Household record
   - Household-Resident pivot record is created/updated
   - Resident record is updated with other personal information
6. Address is displayed by querying through: Resident → Households → House → Street

## Database Structure
```
residents table
├── Has many households (via household_resident pivot)
│
household_resident table (pivot)
├── household_id (FK)
├── resident_id (FK)
└── is_household_head

household table
├── house_id (FK)
└── relationships to house

house table
├── street_id (FK)
├── house_no
└── property_type

street table
├── street_name
└── relationships to houses
```

## Testing
To test the fix:
1. Navigate to Admin/Resident/SubAdmin profile
2. Click "Edit Resident Info" button
3. Change the Street dropdown
4. Verify House Number dropdown updates
5. Select a new house number
6. Submit the form
7. Verify the address updates in the Resident Information section
