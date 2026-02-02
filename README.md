# Where Money Goes 💰

A Progressive Web Application (PWA) for tracking your expenses and understanding your spending habits. Take control of your finances by knowing exactly where your money goes.

## About Where Money Goes

**Where Money Goes** is a personal expense tracking application designed to help you monitor, analyze, and understand your spending patterns. Whether you're trying to stick to a budget, save for a goal, or simply become more financially aware, this app provides the tools you need to manage your money effectively.

## Purpose

The primary purpose of Where Money Goes is to give you complete visibility into your spending habits. By tracking every expense and refund, you can make informed decisions about your finances and identify areas where you can save money.

## Benefits of Tracking Your Expenses

### 1. **Budget Awareness**
- Understand exactly how much you're spending each month
- Compare your actual spending against your monthly budget
- See percentage-based metrics to gauge your financial health

### 2. **Identify Spending Patterns**
- Discover where most of your money goes (categories)
- Identify recurring expenses that might be unnecessary
- Track spending by store to see where you shop most frequently

### 3. **Financial Accountability**
- Create awareness of impulse purchases
- Hold yourself accountable for every dollar spent
- Make conscious decisions about future purchases

### 4. **Goal Achievement**
- Track progress toward savings goals
- Reduce unnecessary spending by seeing it in real-time
- Project future spending based on current trends

### 5. **Household Transparency**
- Share expenses with household members
- See who spent what and when
- Collaborate on household budgeting together

## Key Features

- ✅ **Expense & Refund Tracking** - Record expenses and refunds with visual distinction
- ✅ **Budget Management** - Set monthly budgets and track your spending against them
- ✅ **Category Organization** - Organize expenses by custom categories
- ✅ **Store Tracking** - Track which stores you spend money at
- ✅ **Monthly Projections** - See projected spending based on daily averages
- ✅ **Household Sharing** - Share expenses with family members or roommates
- ✅ **Dark Mode** - Full dark mode support for comfortable viewing
- ✅ **Mobile-First Design** - Optimized for mobile devices with thumb-friendly navigation
- ✅ **Progressive Web App** - Install on your device and use offline
- ✅ **Real-time Updates** - Instant updates using Livewire's reactive components

## Tech Stack

### Backend Framework: Laravel 11
**Why:** Laravel provides a robust, elegant PHP framework with built-in authentication, database migrations, and a powerful ORM (Eloquent). It allows rapid development while maintaining clean, maintainable code.

**How it's used:**
- Authentication and authorization system
- Database migrations for schema management
- Eloquent ORM for database operations
- Routing and middleware for request handling
- Service providers for dependency injection

### Frontend: Livewire 3
**Why:** Livewire enables building dynamic, reactive interfaces using PHP instead of JavaScript, reducing complexity and maintaining a single-language codebase. It provides a SPA-like experience without the overhead of a separate frontend framework.

**How it's used:**
- Real-time reactive components (expense lists, budget overview, projections)
- Form handling with validation
- Dynamic dropdowns with auto-selection
- Search and filter functionality
- Instant UI updates without page reloads

### Styling: Tailwind CSS 3
**Why:** Tailwind's utility-first approach allows rapid UI development with consistent design patterns. It's highly customizable and produces minimal CSS in production builds.

**How it's used:**
- Responsive design (mobile-first approach)
- Dark mode implementation using class-based toggling
- Custom color schemes for expenses (red) vs refunds (green)
- Component styling for buttons, forms, cards, and navigation
- Backdrop blur effects for modern UI elements

### Database: MySQL
**Why:** MySQL is reliable, widely-supported, and perfect for relational data like expenses, categories, stores, and user relationships.

**How it's used:**
- Storing expenses with soft deletes
- Managing user households and relationships
- Category and store organization
- Settings and preferences storage
- Efficient querying with indexes and relationships

### Build Tool: Vite
**Why:** Vite provides lightning-fast hot module replacement during development and optimized production builds. It's the modern standard for Laravel projects.

**How it's used:**
- Asset compilation (CSS and JavaScript)
- Development server with hot reload
- Production optimization and minification
- PostCSS and Tailwind processing

### Progressive Web App (PWA)
**Why:** PWA capabilities allow the app to be installed on devices, work offline, and feel like a native application while being web-based.

**How it's used:**
- Service worker for offline functionality
- Web app manifest for installation
- Mobile-optimized interface
- Fixed bottom navigation for thumb-friendly access
- Home screen installation on iOS and Android

### Additional Technologies

- **Alpine.js** - Lightweight JavaScript for interactive components (dropdowns, modals)
- **Eloquent ORM** - Database abstraction layer for clean data operations
- **Blade Templates** - Laravel's templating engine for views
- **Carbon** - PHP date/time library for date handling and formatting
- **Service Workers** - Offline support and PWA functionality

## Architecture

The application follows a clean, component-based architecture:

- **Models** - Expense, Category, Store, Household, User, Setting
- **Livewire Components** - Reactive UI components for each feature
- **Blade Views** - Template files for rendering HTML
- **Migrations** - Version-controlled database schema
- **Routes** - Clean, RESTful routing structure

## Installation

See [SETUP.md](SETUP.md) for detailed installation instructions.

## License

This project is open-source software.

