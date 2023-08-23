# Ticket Support System Example Project using Laravel 10 + Livewire 3

This is an example project for a Ticket Support System.
Laravel 10 is used as framework with Livewire 3 (Beta) for the front-end.


## Glossary

A system to manage support tickets. Customers register as users and can create tickets,
then admins assign them to agents, and all parties can view ticket statuses.

## Database structure

### Every ticket needs to have:
- title (required)
- text description (required)
- multiple files attached (optional)
- priority (choose from a few options)
- status (choose from a few options like open/closed)
- assigned user agent (foreign key to users table)
- multiple categories (belongsToMany relationship with categories table)
- multiple labels (belongsToMany relationship with labels table)

## Auth

There should be login and register functionality, they may come from starter kit like Laravel Breeze or other one of your choice.

### Every user needs to have one of three roles:
- Regular user (default)
- Agent
- Administrator

New users can register and they are assigned Regular articles role.
There should be one Administration user created with database seeds.
After registration or login, users get inside the system which would look like a typical adminpanel to manage data: menus, tables, CRUDs for administrator.

### Regular users: manage THEIR tickets

After registration/login, user sees the only menu item "Tickets" with a table of tickets only created by themselves.
Table of tickets needs to have dropdown filters: by status, priority and category.
They can add a new ticket, but can't edit/delete tickets.
They can click the ticket title in the table to open the page to see more details and ticket activity log and comments, also may add a comment there (more on that later).

### Agent users: manage THEIR tickets

Similar to regular users, agents see only their tickets, but "their" has a different meaning - not that they created the tickets, but are assigned to them (by admin, more on that later).
They can edit tickets and add comments.

### Admin users: manage everything

Admins see not only tickets table, but also can view more menu items:
- Dashboard with the amount of tickets per status (total / open / closed, etc.)
- Manage Labels, Categories, Priorities and Users, in CRUD way

When editing the ticket, admins can assign Agent user to it - other users shouldn't see that field.
Also, admins should see the menu item called "Logs" which lists all changes that happened to all tickets, like history: who created/updated the ticket and when.

## Ticket Comments

After clicking on ticket, any user can get to its page, and there should be a form to add a comment, and that page shows the list of comments, like on a typical blogpost page.

## Email Notifications

When the new ticket is created, admin should get an email with the link to the Edit form of the ticket.

- - - - -

## How to use without Docker/WSL

- Clone the repository with `git clone`
- Copy `.env.example` file to `.env` and edit database credentials there
- Run `composer install`
- Run `npm install`
- Run `php artisan key:generate`
- Run `php artisan migrate --seed` (it has some seeded data for your testing)
- Launch `http://localhost:8000/` in your browser
- You can login as admin to manage data with default credentials `admin@admin.com` - `password`

## How to use with Docker + WSL

- Clone the repository with `git clone` in a WSL directory
- Copy `.env.example` file to `.env`
- Run `./dock composer install`
- Run `./dock npm install`
- Run `./dock artisan key:generate`
- Run `./dock artisan migrate --seed` (it has some seeded data for your testing)
- Run `./dock start`
- Launch `http://localhost:8000/` in your browser
- You can login as admin to manage data with default credentials `admin@admin.com` - `password`
