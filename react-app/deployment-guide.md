# Deployment Guide for Namecheap

## Step-by-Step Deployment Process

### 1. Build Your Application Locally
```bash
npm run build
```
This creates a `dist` folder with your compiled React application.

### 2. Files to Upload to Namecheap
Upload these files to your Namecheap application directory:

**Required Files:**
- `server.cjs` (the server file we just created)
- `package.json` (updated with Express dependency)
- `dist/` folder (entire contents from your build)

### 3. Namecheap cPanel Setup

#### A. Create Node.js Application
1. Login to Namecheap cPanel
2. Find "Setup Node.js App" 
3. Click "Create Application"
4. Configure:
   - **Node.js Version**: 18.x or 20.x
   - **Application Mode**: Production
   - **Application Root**: `public_html/cari-prop-shop` (or your preferred folder)
   - **Application Startup File**: `server.cjs`
   - **Environment Variables** (if needed):
     - `NODE_ENV=production`

#### B. Upload Files
1. Open "File Manager" in cPanel
2. Navigate to your application root directory
3. Upload:
   - `server.cjs`
   - `package.json`
   - Create `dist` folder and upload all contents from your local `dist` folder

#### C. Install Dependencies & Start
1. Go back to "Setup Node.js App"
2. Select your application
3. Click "Run NPM Install"
4. Wait for installation to complete
5. Click "Start App"

### 4. Verification
- Visit your application URL (provided in cPanel)
- Test navigation to ensure client-side routing works
- Check browser console for any errors

### 5. Troubleshooting

#### Common Issues:
1. **404 Errors on Refresh**: Make sure the catch-all route (`app.get('*')`) is working
2. **Static Files Not Loading**: Verify the `dist` folder structure is correct
3. **App Won't Start**: Check the startup file name matches exactly
4. **Dependencies Missing**: Ensure `npm install` completed successfully

#### Log Access:
- In cPanel Node.js App interface, you can view application logs
- Check for any startup errors or runtime issues

### 6. Environment Variables (Optional)
If your app needs environment variables:
1. In Node.js App setup, add environment variables
2. Common variables:
   - `NODE_ENV=production`
   - `PORT=3000` (usually auto-assigned by Namecheap)

### 7. Domain Configuration
- If using a custom domain, configure it in cPanel
- Update DNS settings if necessary
- SSL certificate setup (usually automatic with Namecheap)

## File Structure on Server
```
public_html/cari-prop-shop/
├── server.cjs
├── package.json
├── node_modules/ (created after npm install)
└── dist/
    ├── index.html
    ├── assets/
    │   ├── index-[hash].js
    │   ├── index-[hash].css
    │   └── [other assets]
    └── [other static files]
```

## Performance Tips
1. Enable gzip compression (usually enabled by default on Namecheap)
2. Set proper cache headers for static assets
3. Monitor application performance through cPanel metrics

## Updates & Maintenance
To update your application:
1. Build locally: `npm run build`
2. Upload new `dist` folder contents
3. Restart the application in cPanel if needed