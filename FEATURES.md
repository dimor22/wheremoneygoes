# Where the Money Goes - Expense Tracking Features

## Overview
This application helps users track their monthly expenses and manage budgets. Users can input expenses with detailed information and set monthly budget goals.

## Features Implemented

### 1. Expense Input System
**Route:** `/expenses`
**Component:** `app/Livewire/Expenses/AddExpense.php`

Users can add expenses with the following information:
- **Amount** - Monetary value (required, decimal with 2 places)
- **Category** - Expense category (required, e.g., Groceries, Entertainment, Bills)
- **Store** - Store/merchant name (required, e.g., Walmart, Amazon)
- **Date** - Date of expense (required, defaults to today)
- **Notes** - Optional additional details

**Validation:**
- All fields except notes are required
- Amount must be numeric and greater than 0.01
- Date must be a valid date
- Form displays validation errors inline

**User Experience:**
- Form resets after successful submission
- Success message displayed after saving
- Date defaults to today's date
- Clean, responsive form layout

### 2. Settings Page
**Route:** `/settings`
**Component:** `app/Livewire/Settings/AppSettings.php`

Users can configure:
- **Monthly Budget** - Set spending limit for the month (required, numeric, min: 0)

**Features:**
- Loads existing budget on page load
- Creates or updates settings per user
- Success message on save
- Prepared for additional settings in the future

### 3. Database Schema

#### Expenses Table
```
- id (primary key)
- user_id (foreign key to users)
- amount (decimal 10,2)
- category (string)
- store (string)
- expense_date (date)
- notes (text, nullable)
- timestamps
```

#### Settings Table
```
- id (primary key)
- user_id (foreign key to users, unique)
- monthly_budget (decimal 10,2, default: 0)
- timestamps
```

### 4. Models & Relationships

#### User Model
- `hasMany` expenses
- `hasOne` setting

#### Expense Model
- `belongsTo` user
- Fillable: user_id, amount, category, store, expense_date, notes
- Casts: amount (decimal:2), expense_date (date)

#### Setting Model
- `belongsTo` user
- Fillable: user_id, monthly_budget
- Casts: monthly_budget (decimal:2)

## Navigation
The application includes navigation links for:
- **Dashboard** - Overview and quick links
- **Add Expense** - Expense input form
- **Settings** - Budget and app settings
- **Profile** - User profile management

Navigation is available in both desktop and mobile layouts.

## Usage

### Adding an Expense
1. Navigate to "Add Expense" from the main menu
2. Fill in the amount, category, store, and date
3. Optionally add notes
4. Click "Add Expense"
5. Form resets for next entry

### Setting Monthly Budget
1. Navigate to "Settings" from the main menu
2. Enter your desired monthly budget
3. Click "Save Settings"

## Next Steps (Future Development)

### Dashboard Analytics
The dashboard is prepared to display:
- Monthly spending summary
- Budget vs. actual spending
- Category breakdown
- Recent expenses list
- Spending trends

### Suggested Features
- Expense listing/history page
- Edit/delete expenses
- Category management
- Recurring expenses
- Export to CSV/PDF
- Spending charts and visualizations
- Budget alerts
- Multiple budget categories
- Search and filter expenses

## Technical Details

**Framework:** Laravel 12
**UI Framework:** Livewire 3 + Tailwind CSS
**Database:** SQLite (easily swappable to MySQL/PostgreSQL)
**Authentication:** Laravel Breeze with Livewire

## File Locations

**Routes:** `routes/web.php`
**Controllers:** Livewire components in `app/Livewire/`
**Views:** `resources/views/livewire/`
**Models:** `app/Models/`
**Migrations:** `database/migrations/`
