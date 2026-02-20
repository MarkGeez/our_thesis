# E-Barangay Reports Module Documentation

## Overview
The Reports Module is a comprehensive feature of the E-Barangay Management System that allows administrators to generate, view, and export various types of reports in multiple formats including web view and PDF.

## Features

### Report Types
1. **Blotter Reports** - Records of complaints and disputes
2. **Certificate Reports** - Request and issuance history
3. **Active Logs Reports** - User activity tracking
4. **Population Reports** - Demographic statistics
5. **Household Reports** - Household and residency information

### Functionality
- **Dynamic Filters** - Apply optional filters based on report type
- **Date Range Selection** - Filter data by date range
- **Table Display** - View results in an organized table format
- **Print Functionality** - Direct browser printing capability
- **PDF Export** - Download reports as PDF files with professional formatting

## Installation

### Prerequisites
- Laravel 12.0+
- PHP 8.2+
- Composer

### Setup Steps

1. **Install DomPDF Package** (if not already installed):
```bash
composer require barryvdh/laravel-dompdf
```

2. **Publish Configuration** (optional):
```bash
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

3. **Clear Cache**:
```bash
php artisan cache:clear
php artisan config:clear
```

## File Structure

```
resources/views/admin/
├── reports.blade.php                  # Main reports interface
└── reports/
    ├── blotter-pdf.blade.php         # Blotter PDF template
    ├── certificate-pdf.blade.php     # Certificate PDF template
    ├── active-log-pdf.blade.php      # Active logs PDF template
    ├── population-pdf.blade.php      # Population PDF template
    └── household-pdf.blade.php       # Household PDF template

app/Http/Controllers/
└── ReportsController.php             # Main controller handling all report logic

config/
└── dompdf.php                        # DomPDF configuration

routes/
└── web.php                           # Report routes (included in admin group)
```

## Database Models Used

- `Blotter` - Complaint records
- `CertificateRequest` - Certificate request history
- `ActiveLog` - User activity logs
- `Resident` - Population data
- `Household` - Household information
- `House` - House details and street information
- `User` - User information for activity logs

## Routes

All routes are protected with the `auth` and `role:admin` middleware.

```
GET    /admin/reports                    - Show reports page
POST   /admin/reports/blotter            - Generate blotter report
POST   /admin/reports/certificate        - Generate certificate report
POST   /admin/reports/active-log         - Generate active logs report
POST   /admin/reports/population         - Generate population report
POST   /admin/reports/household          - Generate household report
GET    /admin/reports/filter-options/{type} - Get filter options for report type
```

## Controller Methods

### ReportsController

#### Public Methods

**`index()` - View**
Displays the main reports page with filter options.

**`generateBlotterReport(Request $request)` - JSON/PDF**
Generates blotter reports with optional filters:
- `date_from` - Start date
- `date_to` - End date
- `status` - Blotter status
- `complainant` - Complainant name
- `respondent` - Respondent name
- `export` - Set to 'pdf' for PDF export

**`generateCertificateReport(Request $request)` - JSON/PDF**
Generates certificate reports with optional filters:
- `date_from` - Start date
- `date_to` - End date
- `certificate_type` - Type of certificate
- `purpose` - Purpose of certificate
- `status` - Request status (pending, approved, declined)
- `export` - Set to 'pdf' for PDF export

**`generateActiveLogReport(Request $request)` - JSON/PDF**
Generates activity logs with optional filters:
- `date_from` - Start date
- `date_to` - End date
- `action` - Type of action
- `user_id` - User ID
- `export` - Set to 'pdf' for PDF export

**`generatePopulationReport(Request $request)` - JSON/PDF**
Generates population statistics with optional filters:
- `gender` - Male/Female/All
- `age_range` - Age group (0-12, 13-18, 19-35, 36-60, 60+)
- `civil_status` - Civil status
- `religion` - Religion
- `birthday_month` - Month of birth (for birthday listings)
- `export` - Set to 'pdf' for PDF export

**`generateHouseholdReport(Request $request)` - JSON/PDF**
Generates household reports with optional filters:
- `house_number` - House number
- `head_of_household` - Name of household head
- `property_type` - Type of property
- `export` - Set to 'pdf' for PDF export

**`getFilterOptions($reportType)` - JSON**
Returns available filter options for a specific report type.

#### Protected Methods

- `exportBlotterPdf($reports)` - PDF export handler for blotter reports
- `exportCertificatePdf($reports)` - PDF export handler for certificate reports
- `exportActiveLogPdf($reports)` - PDF export handler for active logs
- `exportPopulationPdf($reports)` - PDF export handler for population reports
- `exportHouseholdPdf($reports)` - PDF export handler for household reports
- `generateBlotterHtml($reports)` - HTML generation for blotter PDF
- `generateCertificateHtml($reports)` - HTML generation for certificate PDF
- `generateActiveLogHtml($reports)` - HTML generation for active logs PDF
- `generatePopulationHtml($reports)` - HTML generation for population PDF
- `generateHouseholdHtml($reports)` - HTML generation for household PDF

## Frontend Usage

### Report Generation Flow

1. User navigates to `/admin/reports`
2. Selects a report type from dropdown
3. Optional filters appear based on report type
4. Can set date range (common for all reports)
5. Clicks "Generate Report" button
6. Results display in table format
7. Can click "Print" for browser printing or "Export to PDF" for download

### JavaScript Functions

- `generateReport(reportType)` - Fetches report data and displays results
- `displayResults(data)` - Renders results in HTML table
- `exportToPdf(reportType)` - Initiates PDF download
- `loadFilterOptions(reportType)` - Loads available filters dynamically
- `populateFilterOptions(reportType, data)` - Updates filter dropdowns

## Styling

The module uses:
- **Bootstrap 5.3.2** - Responsive grid and components
- **Font Awesome 6.5.0** - Icons
- **Custom CSS** - Professional styling with navy and blue color scheme

Color Scheme:
- Navy: `#0a3a8a`
- Header Blue: `#4a7ebb`
- Text: `#111`
- Muted: `#666`

## PDF Templates

All PDF templates follow a consistent barangay document format:
- Header with barangay logo, seal, and official titles
- Report title and generation timestamp
- Data table with status badges
- Footer with contact information and page numbers
- Professional styling suitable for official documentation

### PDF Features
- Automatic page breaks for large datasets (chunking)
- Status badges with color-coding
- Summary statistics (where applicable)
- Footer with contact and generated information
- Responsive layout for different paper sizes

## Advanced Features

### Dynamic Filter Loading
Filter options are dynamically loaded based on report type via AJAX:
```javascript
fetch(`/admin/reports/filter-options/${reportType}`)
```

### Conditional Filters
Filters are only applied if they have values, keeping queries optimized:
```php
if ($request->filled('status')) {
    $query->where('current_status', $request->status);
}
```

### Chunked PDF Rendering
Large reports are split across multiple pages:
```php
@foreach($reports->chunk(50) as $chunk)
    // Render page with chunk
@endforeach
```

## Security

All routes are protected with:
- `auth` middleware - User must be authenticated
- `role:admin` middleware - User must have admin role

All user inputs are validated and sanitized:
- Date inputs validated as dates
- Text inputs escaped in SQL queries
- CSRF protection via token

## Performance Considerations

1. **Query Optimization**
   - Uses `with()` for eager loading relationships
   - Applies filters before database query
   - Limits results with optional chunking

2. **Frontend Performance**
   - Loading indicator while generating reports
   - Table virtualization optional for large datasets
   - AJAX requests prevent page reload

3. **PDF Generation**
   - DomPDF handles large PDF generation efficiently
   - Chunking prevents memory overload
   - CSS is optimized for fast rendering

## Troubleshooting

### DomPDF Not Found
**Error:** `Undefined type 'Barryvdh\DomPDF\Facade\Pdf'`

**Solution:**
```bash
composer require barryvdh/laravel-dompdf
php artisan cache:clear
php artisan config:clear
```

### No Data Returned
1. Verify database has data in respective tables
2. Check date range filters aren't too restrictive
3. Ensure authentication is working
4. Check user role is 'admin'

### PDF Export Not Working
1. Ensure `storage/logs/` directory is writable
2. Check DomPDF config in `config/dompdf.php`
3. Verify all image URLs are accessible
4. Check Laravel logs for errors

### Styling Issues in PDF
1. Avoid nested CSS - use utility classes
2. Verify image paths are absolute URLs or asset paths
3. Test with simpler styles first
4. Check browser console for JavaScript errors

## Configuration

### Adding New Report Types

1. Add method to `ReportsController`:
```php
public function generateNewReport(Request $request)
{
    // Query building logic
    if ($request->input('export') === 'pdf') {
        return $this->exportNewReportPdf($reports);
    }
    return response()->json([...]);
}
```

2. Add route in `routes/web.php`:
```php
Route::post('/reports/new-report', [ReportsController::class, 'generateNewReport'])
    ->name('reports.new-report');
```

3. Create PDF template:
```
resources/views/admin/reports/new-report-pdf.blade.php
```

4. Update frontend HTML and JavaScript in `reports.blade.php`

## Future Enhancements

- [ ] Scheduled report generation
- [ ] Email delivery of reports
- [ ] Custom field selection for reports
- [ ] Report templates and saving
- [ ] Advanced charting and analytics
- [ ] Data export to Excel/CSV
- [ ] Report signature support
- [ ] Multi-language support

## Support and Maintenance

For issues or feature requests related to the Reports Module, please contact the development team or create an issue in the project repository.

---

**Module Version:** 1.0.0  
**Last Updated:** February 2026  
**Laravel Version:** 12.0+
