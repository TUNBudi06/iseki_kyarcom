# 🚀 Quick Start Guide - Demo Pages

## What's Been Created

✅ **2 Demo Pages:**
- **Home Page** (`/`) - Hero section with feature cards
- **About Page** (`/about`) - Technology showcase

✅ **Default Layout** - Shared navigation and footer with `app.css` imported

✅ **Routing Integration:**
- Wayfinder TypeScript routes
- Inertia Route Helper for URL building
- Type-safe navigation

✅ **UI Components:**
- shadcn Button component
- shadcn Card component
- Tailwind CSS styling

---

## 🎯 Access the Demo

### Servers Running:
- **Vite Dev Server:** http://localhost:5173
- **Laravel Server:** http://127.0.0.1:8000

### Demo Pages:
- **Home:** http://127.0.0.1:8000/
- **About:** http://127.0.0.1:8000/about

---

## 📁 Files Created

### Frontend Components
```
resources/js/
├── Layouts/
│   └── DefaultLayout.svelte      # Layout with app.css import
├── Pages/
│   ├── Home.svelte               # Home page with features
│   └── About.svelte              # About page with tech stack
└── routes/
    └── index.ts                  # Generated Wayfinder routes
```

### Backend
```
app/Http/Controllers/
├── HomeController.php            # Home page controller
└── AboutController.php           # About page controller

routes/
└── web.php                       # Route definitions (updated)

app/Http/Middleware/
└── HandleInertiaRequests.php     # Added baseUrl to shared props

resources/views/
└── app.blade.php                 # Inertia root view (created)
```

### shadcn Components
```
resources/js/shadcn/components/ui/
├── button/                       # Button component
└── card/                         # Card component
```

---

## 🔧 How It Works

### 1. Route Definition (Laravel)
```php
// routes/web.php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
```

### 2. Wayfinder Generation
```bash
php artisan wayfinder:generate
```
Generates: `resources/js/routes/index.ts`

### 3. Usage in Svelte
```typescript
import { route, routeUrl } from '@tunbudi06/inertia-route-helper';
import { home, about } from '$routes';

// Get URL
<Link href={routeUrl(home())}>Home</Link>

// Get route object
const homeRoute = route(home());
// { url: 'http://localhost/home', method: 'GET' }
```

---

## 🎨 Components Used

### DefaultLayout
- Imports `app.css` globally
- Navigation with Home/About links
- Uses Wayfinder routes
- Footer section
- Children slot for pages

### Home Page Features
- Hero with dynamic message prop
- Feature cards grid
- CTA buttons
- Route helper demo
- shadcn Button & Card components

### About Page Features
- Technology cards (6 items)
- Route helper features list
- Code example section
- Current route info
- External documentation links

---

## 🚦 Current Status

✅ Vite dev server running  
✅ Laravel server running  
✅ Wayfinder routes generated  
✅ shadcn components installed  
✅ TypeScript configured  
✅ Path aliases working  

### Known IDE Warnings
The IDE may show warnings for `$routes` imports initially. These will resolve after:
- IDE restart
- TypeScript server restart
- Or simply ignore them - the code works fine!

---

## 📝 Quick Commands

### Development
```bash
# Start Vite
npm run dev
# or
bun run dev

# Start Laravel
php artisan serve

# Generate routes after route changes
php artisan wayfinder:generate
```

### Add More shadcn Components
```bash
npx shadcn-svelte@latest add [component-name]
```

Examples:
```bash
npx shadcn-svelte@latest add input
npx shadcn-svelte@latest add dialog
npx shadcn-svelte@latest add dropdown-menu
npx shadcn-svelte@latest add form
```

---

## 🎯 Testing the Features

### 1. Navigation
- Click "Home" in nav → Goes to `/`
- Click "About" in nav → Goes to `/about`
- No page reload (SPA behavior)

### 2. Route Helper Demo
- Home page shows:
  - About URL generated with `routeUrl()`
  - Full route object from `route()`
  
### 3. Props Passing
- Home page receives `message` prop from controller
- About page receives `title` and `description` props

### 4. shadcn Components
- Buttons with different variants
- Cards with header/content/footer
- Responsive design
- Tailwind styling

---

## 📖 Documentation

See `DEMO_PAGES.md` for complete documentation including:
- Detailed setup explanation
- Code examples
- Troubleshooting guide
- Development workflow
- Technology stack details

---

## ✨ What Makes This Special

1. **Layout Pattern** - `app.css` imported once in Layout (outside pages)
2. **Type Safety** - Full TypeScript support with Wayfinder
3. **Route Helper** - Clean URL building with `route()` and `routeUrl()`
4. **SPA Navigation** - No page reloads with Inertia Links
5. **Modern Stack** - Laravel 12 + Svelte 5 + Inertia 2
6. **Component Library** - Beautiful shadcn-ui components
7. **Path Aliases** - Clean imports with `$routes`, `$shadcn`, `$lib`

---

## 🎉 You're All Set!

Visit **http://127.0.0.1:8000/** to see the demo in action!

Both servers are running and the application is ready to use. Navigate between Home and About to see the Inertia SPA navigation and route helper in action.

Happy coding! 🚀

