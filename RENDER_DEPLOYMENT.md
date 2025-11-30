# Render Deployment Instructions

## 📁 Upload Environment File

**Option 1: Upload .env.render file**
1. In Render dashboard, go to your web service
2. Go to "Environment" tab
3. Click "Add from .env file"
4. Upload the `.env.render` file from this repository

**Option 2: Manual Environment Variables**
Set these variables in Render dashboard with your actual values:

```
APP_NAME=Attendify
APP_ENV=production
APP_DEBUG=false
APP_KEY=[Generate new key with: php artisan key:generate --show]
APP_URL=https://your-app-name.onrender.com
DATABASE_HOST=[Your PostgreSQL host]
DATABASE_PORT=5432
DATABASE_NAME=[Your database name]
DATABASE_USER=[Your database user]
DATABASE_PASSWORD=[Your database password]
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
LOG_LEVEL=error
MAIL_MAILER=log
```

## 🚀 Deploy Steps

1. Connect GitHub repository to Render
2. Use `render.yaml` for automatic configuration
3. Upload environment variables (Option 1 or 2 above)
4. Deploy service

The app will automatically:
- Install dependencies
- Build assets
- Run migrations
- Seed database
- Start server

## 👥 Demo Accounts
- **Admin**: admin@attendify.com / password
- **Teacher**: john@attendify.com / password
- **Student**: alice@attendify.com / password