# TMC DASH 'N' DINE POS

A local PHP + MySQL restaurant point-of-sale starter application for XAMPP.

## Included
- Login with role-based access (administrator/manager/cashier)
- POS order cart, menu search/categories, payment method, amount received and change calculation
- Printable receipt
- Sales history and dashboard
- Product/menu management and price updates
- Recipe setup screen for ingredient-level stock deduction
- Staff password changes
- Stock item register, adjustments and movement records
- Recipe-based ingredient deduction when recipes are configured
- Expense records and date-filtered sales reports
- Cash shift opening and closing reconciliation
- CSRF protection, prepared SQL statements, password hashing and audit log foundation

## Installation
1. Copy the `tmc_pos_project` folder into `C:\xampp\htdocs\` and rename it to `tmc_pos` if desired.
2. Start Apache and MySQL in XAMPP.
3. Open `http://localhost/tmc_pos/setup.php`.
4. The setup page creates the `tmc_pos` database, tables, categories and printed-menu products.
5. Sign in at `http://localhost/tmc_pos/login.php` using:
   - Username: `admin`
   - Temporary password: `ChangeMe123!`
6. Change the temporary password before using the system with real sales. Delete `setup.php` after successful installation.

## Database configuration
Edit `config/config.php` if your MySQL host, database user or password differs from the XAMPP defaults.

## Important first-use configuration
- Printed prices have been entered as shown on the printed menu. The 300ml soft drink offer is represented as one sale unit for two bottles at $1.00.
- The printed menu says quarter chicken $4.00, T-bone steak $4.00 and pork chop $3.50. Confirm these prices with management before live use.
- Add actual stock items and opening quantities in Inventory.
- Configure recipes before expecting meal sales to deduct ingredient quantities. Until recipes are entered, sales do not automatically change ingredient stock.
- This initial version tracks cash shift expected cash using cash payments. Non-cash payments are reported separately and should not be counted in the drawer.
- Profit is not presented as net profit. A proper cost-of-goods calculation requires accurate purchase costs and recipes.

## Before production use
This is a working local starter system, not a certified fiscalisation or tax-invoice product. Test with sample transactions first, configure backups, change the admin password, secure the local network, and confirm legal receipt/fiscal requirements with the relevant authorities. Add an approved refund/void workflow and a tested automated backup routine before relying on it for live business records.
