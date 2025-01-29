# Dynamic Form Project

This project is a dynamic form system that allows users to create and display custom forms. The system enables users to design various forms using different types of fields.

## Features

- Create and edit dynamic forms
- Support for various field types including text, number, email, date, checkbox, radio, and more
- Responsive design using Tailwind CSS

## Supported Field Types

The following field types are supported in this project:

- **Text**: A simple text field for short input.
- **Textarea**: A field for longer text input.
- **Number**: A field for numeric values only.
- **Email**: A field for email addresses.
- **Password**: A field for secure password input.
- **Date**: A field for date values.
- **Datetime**: A field for date and time values.
- **Checkbox**: A field for boolean values (true/false).
- **Radio**: A field for selecting one option from a set.
- **Select**: A dropdown field for selecting one option.
- **Multi-select**: A dropdown field for selecting multiple options.
- **File Upload**: A field for uploading files.
- **Image Upload**: A field for uploading images.
- **URL**: A field for entering URLs.
- **Phone**: A field for entering phone numbers.
- **Color Picker**: A field for selecting colors.
- **Range**: A field for selecting a range of values.

## Requirements

To run this project, you need to have the following installed:

- **PHP**: Version 8.1 or higher
- **Laravel**: Version 10 or higher
- **Node.js**: Version 18 or higher

## Installation and Setup

Follow these steps to set up the project:

1. **Clone the repository:**

   ```bash
   git clone <repository-url>
   cd dynamic_form/

2. **Install Composer**

    ```bash
   composer install

3. **Install npm**

    ```bash
   npm install


3. **set .env**

    ```bash
   cp .env.example .env

4. **Migrate database && seed data **

    ```bash
   php artisan migrate --seed


5. **Generate key **

    ```bash
   php artisan key:generate


6. **serve and build **

    ```bash
   php artisan serve
   
   npm run dev
