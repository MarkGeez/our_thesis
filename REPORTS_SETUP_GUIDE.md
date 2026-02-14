# Reports Module - Quick Setup Guide

## Installation & Setup (5 minutes)

### Step 1: Install DomPDF Package
```bash
cd c:\xampp\htdocs\thesis
composer require barryvdh/laravel-dompdf
```

### Step 2: Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
```

### Step 3: Verify Installation
Navigate to `/admin/reports` and you should see the reports interface.

## Files Added/Modified

### New Files Created
- `app/Http/Controllers/ReportsController.php` - Main controller (380 lines)
- `config/dompdf.php` - DomPDF configuration
- `resources/views/admin/reports.blade.php` - Main UI (completely rewritten)
- `resources/views/admin/reports/blotter-pdf.blade.php` - PDF template
- `resources/views/admin/reports/certificate-pdf.blade.php` - PDF template
- `resources/views/admin/reports/active-log-pdf.blade.php` - PDF template
- `resources/views/admin/reports/population-pdf.blade.php` - PDF template
- `resources/views/admin/reports/household-pdf.blade.php` - PDF template
- `REPORTS_MODULE_DOCUMENTATION.md` - Complete documentation

### Modified Files
- `routes/web.php` - Added ReportsController import and 6 new routes

## Features Implemented

### ✅ Report Types
- [x] Blotter Reports
- [x] Certificate Reports
- [x] Active Logs Reports
- [x] Population Reports
- [x] Household Reports

### ✅ Filtering & Selection
- [x] Report type dropdown
- [x] Date range (From/To)
- [x] Blotter: status, complainant, respondent
- [x] Certificates: type, purpose, status
- [x] Active Logs: action type, user
- [x] Population: gender, age range, civil status, religion
- [x] Households: house number, head name, property type

### ✅ Actions
- [x] Generate button with AJAX loading
- [x] Dynamic filter options loading
- [x] Table display with sorting
- [x] Print button for browser printing
- [x] Export to PDF button with downloads

### ✅ UI/UX
- [x] Professional styling with navy/blue theme
- [x] Responsive mobile-friendly design
- [x] Loading indicators
- [x] Result count display
- [x] Status badges with colors
- [x] Bootstrap 5.3.2 integration
- [x] Font Awesome icons

### ✅ Backend
- [x] Clean ReportsController with helper methods
- [x] Dynamic query building with conditional filters
- [x] Eloquent relationships
- [x] Input validation
- [x] Professional PDF generation
- [x] Chunked rendering for large datasets

### ✅ PDF Features
- [x] Official barangay header/footer
- [x] Contact information integration
- [x] Page numbering
- [x] Status color badges
- [x] Summary statistics (population)
- [x] Household detail cards
- [x] Multi-page support with automatic breaks

## How to Use

### For Administrators

1. **Navigate to Reports**
   - Go to `/admin/reports` in the admin panel
   - Or click "Reports" in the sidebar

2. **Select Report Type**
   - Choose from: Blotter, Certificate, Active Logs, Population, Household

3. **Set Filters**
   - All reports: Date From/To (optional)
   - Additional filters appear based on report type

4. **Generate Report**
   - Click "Generate Report" button
   - Wait for data to load (shows loading spinner)

5. **View Results**
   - Table displays filtered data
   - Shows total record count

6. **Export Options**
   - **Print**: Opens browser print dialog
   - **PDF**: Downloads PDF file with professional formatting

### Example Workflows

**Blotter Report for Dispute Cases:**
1. Select "Blotter Reports"
2. Set Date From: Start of month
3. Set Status: "Ongoing"
4. Click Generate
5. Click "Export to PDF" to save

**Population Statistics:**
1. Select "Population Reports"
2. Set Gender: "Male"
3. Set Age Range: "60+"
4. Click Generate
5. View statistics and member list

**Certificate Requests:**
1. Select "Certificate Reports"
2. Set Status: "Pending"
3. Click Generate
4. Review pending requests
5. Print or export to PDF

## Customization

### Adding Filter Options
Edit the switch statement in `getFilterOptions()` method in ReportsController:

```php
case 'blotter':
    $options = [
        'statuses' => Blotter::distinct('current_status')->pluck('current_status'),
        // Add more options here
    ];
    break;
```

### Changing PDF Styling
Edit the `<style>` section in PDF template files:
```html
<!-- In resources/views/admin/reports/certificate-pdf.blade.php -->
<style>
    :root {
        --navy: #0a3a8a;
        --header-blue: #4a7ebb;
        /* Customize colors */
    }
</style>
```

### Adding New Report Type
1. Create new method in ReportsController
2. Add route in web.php
3. Add option in reports.blade.php dropdown
4. Add filter section HTML
5. Add JavaScript handler
6. Create PDF template
7. Update getFilterOptions() method

## Database Requirements

The module works with existing tables:
- `blotters` - Must have: current_status, plaintiffName, defendantName, blotterDescription
- `certificateRequests` - Must have: certificate_type, purpose, status
- `activeLog` - Must have: action, model, description
- `residents` - Must have: firstName, lastName, age, sex, birthday, religion
- `households` - Must have house_id, relationship with residents
- `houses` - Must have house_no, property_type, street_id
- `streets` - Must have street_name

## Troubleshooting

### Report not showing data?
1. Check database has records
2. Verify date range isn't too restrictive
3. Check browser console for JavaScript errors
4. Verify filters are set correctly

### PDF export failing?
```bash
# Ensure storage is writable
chmod -R 755 storage/

# Check DomPDF config
php artisan config:cache
```

### Styling issues in PDF?
- Check image URLs are accessible
- Verify CSS is inline or in style tags
- Avoid complex CSS grid layout
- Test with simpler styles first

## Performance Tips

1. **For Large Datasets**
   - Add date range filters to narrow results
   - Use specific filter criteria
   - Reports automatically chunk into pages

2. **For PDF Generation**
   - PDFs are generated on-demand
   - Large reports take a few seconds
   - Images are embedded for standalone PDFs

3. **For Client Performance**
   - Make date filters default to current month
   - Limit initial report scope
   - Use pagination if available

## Support

For issues or customization needs:
1. Check REPORTS_MODULE_DOCUMENTATION.md
2. Review the controller code comments
3. Check Laravel logs: `storage/logs/laravel.log`
4. Verify DomPDF is installed: `composer show | grep dompdf`

## Version History

**v1.0.0** (February 2026)
- Initial release with all 5 report types
- PDF export functionality
- Dynamic filtering
- Professional UI

---

**Ready to use!** Navigate to `/admin/reports` to start generating reports.
