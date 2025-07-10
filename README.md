![prism](https://github.com/user-attachments/assets/e97667bc-1335-48f1-8c23-474d3f31f49a)

# AI Chat - Laravel Livewire Starter Kit

A modern AI chat starter kit built with Laravel Livewire, featuring real-time AI responses using Prism and TailwindCSS.

## Introduction

This AI Chat application provides a solid foundation for building AI-powered chat applications with Laravel Livewire. It leverages Laravel's powerful ecosystem combined with the [Prism PHP SDK](https://prismphp.com/) to deliver AI responses through background job processing, creating a dynamic and engaging user experience.

## Features

- **Real-time AI Responses**: AI responses processed through background jobs with live polling updates
- **Reasoning Support**: Built-in support for AI models with reasoning capabilities
- **Multiple AI Providers**: Support for OpenAI, Anthropic, Google Gemini, Ollama, Groq, Mistral, DeepSeek, xAI, and VoyageAI
- **Authentication System**: Built-in user authentication and management
- **Appearance Settings**: Light/dark mode support with system preference detection
- **Custom Theming**: Shadcn integration allows easy theme customization via CSS variables
- **Chat Sharing**: Share conversations with other users
- **Livewire Components**: Modern reactive UI components for seamless user interactions

## Tech Stack

- **Backend**: Laravel 12.x, Prism PHP SDK
- **Frontend**: Laravel Livewire with Blade templates
- **Styling**: TailwindCSS 4.x, Shadcn components
- **Database**: SQLite (configurable to MySQL/PostgreSQL)
- **Authentication**: Laravel Sanctum
- **Real-time**: Background job processing with Livewire polling

## Prerequisites

- **PHP 8.3+** with extensions:
  - curl, dom, fileinfo, filter, hash, mbstring, openssl, pcre, pdo, session, tokenizer, xml
- **Composer 2.x**
- **Node.js 18+** and npm/bun (for asset compilation)
- **SQLite** (or MySQL/PostgreSQL if preferred)

## Installation

Installation can be done using the Laravel installer:

```bash
laravel new --using=pushpak1300/ai-chat my-ai-chat
cd my-ai-chat
```

Or using Composer:

```bash
composer create-project pushpak1300/ai-chat my-ai-chat
cd my-ai-chat
```

After installation:

```bash
# Install frontend dependencies (for asset compilation)
npm install

# Generate application key (if not done automatically)
php artisan key:generate

# Create database file (for SQLite)
touch database/database.sqlite

# Run migrations
php artisan migrate

# Start the development server
composer run dev
```

The `composer run dev` command runs multiple processes concurrently: Laravel server, queue worker for background jobs, logs monitoring, and Vite for asset compilation. If you encounter issues, run them separately.

## Configuration

### Environment Setup

Copy the example environment file and configure your settings:

```bash
cp .env.example .env
```

### Theme Customization

The application uses Shadcn components with TailwindCSS for styling. All UI components are rendered server-side with Livewire. To customize the theme:

1. Visit [tweakcn.com](https://tweakcn.com) to generate custom CSS variables
2. Update the CSS variables in `resources/css/app.css`
3. The changes will automatically apply to all Shadcn components across Livewire views

### AI Provider Configuration

**Note**: You don't need to configure all providers. The application will work with any combination of the providers you set up.

### Configuring AI Models

AI models are defined in the `app/Enums/ModelName.php` file. This enum defines which models are available in your application and their metadata.

#### Understanding the ModelName Enum

The [`ModelName` enum](app/Enums/ModelName.php) serves as the central configuration point for all AI models in your application. Here's how it works:

```php
<?php

namespace App\Enums;

use Prism\Prism\Enums\Provider;

enum ModelName: string
{
    // OpenAI Models
    case GPT_4O = 'gpt-4o';
    case GPT_4O_MINI = 'gpt-4o-mini';
    case O1_MINI = 'o1-mini';
    case O1_PREVIEW = 'o1-preview';

    // Anthropic Models
    case CLAUDE_3_5_SONNET = 'claude-3-5-sonnet-20241022';
    case CLAUDE_3_5_HAIKU = 'claude-3-5-haiku-20241022';
    case CLAUDE_3_OPUS = 'claude-3-opus-20240229';

    // Google Gemini Models
    case GEMINI_1_5_PRO = 'gemini-1.5-pro';
    case GEMINI_1_5_FLASH = 'gemini-1.5-flash';

    // Add more models as needed...
}
```

#### Adding New Models

To add support for new AI models, follow these steps:

1. **Add the Model Case**: Add a new case to the enum with the exact model identifier used by the provider:

```php
case NEW_MODEL = 'provider-model-name';
```

2. **Implement Required Methods**: Each model must implement several methods:

```php
public function getName(): string
{
    return match ($this) {
        self::NEW_MODEL => 'Human-Readable Name',
        // ... other cases
    };
}

public function getDescription(): string
{
    return match ($this) {
        self::NEW_MODEL => 'Brief description of model capabilities',
        // ... other cases
    };
}

public function getProvider(): Provider
{
    return match ($this) {
        self::NEW_MODEL => Provider::YourProvider,
        // ... other cases
    };
}
```

## Deployment

### Easy Deployment Options

For hassle-free deployment, consider these Laravel-optimized hosting platforms:

#### Laravel Cloud

Deploy directly with [Laravel Cloud](https://cloud.laravel.com/) for seamless integration.

#### Sevalla

[Sevalla.com](https://sevalla.com/) offers Laravel-focused hosting with a free trial.

## Roadmap

This application has been successfully converted from Inertia.js + Vue.js to Laravel Livewire for simplified architecture and better maintainability. We're continuously working to enhance the AI Chat experience. Here's what's coming:

- **Multimodal Support**: Image, audio, and video processing capabilities
- **Tool Call Support**: Function calling and tool integration for enhanced AI interactions
- **Image Generation**: Built-in support for AI image generation models
- **Enhanced Real-time Features**: Improved polling mechanisms and live updates

## Security

### Reporting Security Issues

If you discover security vulnerabilities, please email [pushpak1300@gmail.com](mailto:pushpak1300@gmail.com) instead of using the issue tracker.

## Troubleshooting

### Common Issues

**"Provider not configured" errors:**

- Ensure the required API key is set in your `.env` file
- Verify the API key is valid and has sufficient credits/quota
- Check that the provider service is operational

**AI responses not appearing:**

- Verify that the queue worker is running (`php artisan queue:listen`)
- Check that background job processing is working correctly
- Ensure Livewire polling is functioning (every 2 seconds by default)
- Review application logs for any job failures

**Livewire components not updating:**

- Verify that Livewire is properly installed (`composer require livewire/livewire`)
- Check browser console for JavaScript errors
- Ensure proper CSRF token configuration

**Model not appearing in UI:**

- Confirm the model is added to `ModelName` enum
- Verify the provider is properly configured
- Check that Livewire components are rendering correctly
- Review browser console for JavaScript errors

### Getting Help

- **Documentation**: [Prism PHP Documentation](https://prismphp.com/)
- **Issues**: [GitHub Issues](https://github.com/pushpak1300/ai-chat/issues)

## Contributing

Contributions are welcome!

### Development Setup

```bash
# Clone the repository
git clone https://github.com/pushpak1300/ai-chat.git
cd ai-chat

# Install dependencies
composer install
npm install

# Set up environment
cp .env.example .env
php artisan key:generate

# Set up database
touch database/database.sqlite
php artisan migrate

# Run development server with all services
composer run dev
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

Built with ❤️ using [Laravel](https://laravel.com), [Livewire](https://livewire.laravel.com), and [Prism](https://prismphp.com)
