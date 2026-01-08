# whereMoneyGoes - Laravel Livewire App

A simple Laravel application with Livewire and authentication.

## Features

- **Laravel 12** - Latest version of Laravel framework
- **Livewire 3** - For reactive components
- **Laravel Breeze** - Simple authentication scaffolding with Livewire
- **SQLite Database** - Lightweight database for development
- **Tailwind CSS** - For styling

## What's Included

### Authentication
- User registration
- Login/Logout
- Password reset
- Email verification
- Profile management

### Example Livewire Component
A simple counter component demonstrating Livewire's reactive capabilities, visible on the dashboard after login.

## Getting Started

The application is already set up and ready to use! Here's how to run it:

### 1. Start the Development Server

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

### 2. Compile Frontend Assets (Optional)

If you make changes to CSS/JS, run:

```bash
npm run dev
```

For production build:

```bash
npm run build
```

## Usage

1. **Register a new account** at `/register`
2. **Login** at `/login`
3. **View the dashboard** at `/dashboard` to see the Livewire counter example
4. **Edit your profile** at `/profile`

## Database

The app uses SQLite database located at:
- `database/database.sqlite`

All migrations have been run. The database includes:
- Users table
- Password reset tokens
- Sessions
- Cache
- Job queue tables

## Creating New Livewire Components

To create a new Livewire component:

```bash
php artisan make:livewire ComponentName
```

This creates:
- Component class: `app/Livewire/ComponentName.php`
- View file: `resources/views/livewire/component-name.blade.php`

Use the component in any Blade template:

```blade
<livewire:component-name />
```

## File Structure

```
whereMoneyGoes/
├── app/
│   └── Livewire/          # Livewire components
├── database/
│   ├── migrations/        # Database migrations
│   └── database.sqlite    # SQLite database
├── resources/
│   ├── views/
│   │   ├── livewire/      # Livewire component views
│   │   ├── auth/          # Authentication views
│   │   ├── profile/       # Profile views
│   │   └── dashboard.blade.php
│   ├── css/
│   └── js/
├── routes/
│   └── web.php           # Web routes
└── .env                  # Environment configuration
```

## Environment Configuration

Key settings in `.env`:
- `DB_CONNECTION=sqlite` - Using SQLite database
- `APP_URL=http://localhost:8000`

## Additional Commands

### Run migrations
```bash
php artisan migrate
```

### Clear cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Run tests
```bash
php artisan test
```

## Next Steps

You can now:
1. Create more Livewire components for your expense tracking features
2. Add new migrations for expense-related tables
3. Build out the UI for tracking expenses
4. Add charts and reports using Livewire components

Happy coding! 🚀
