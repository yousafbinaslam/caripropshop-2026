# CariPropShop - GitHub Setup Instructions

## Step 1: GitHub Authentication

### Option A: Using GitHub CLI (Recommended)

1. Open Terminal and run:
```bash
gh auth login
```

2. Select the following options:
   - GitHub.com
   - HTTPS
   - Login with web browser

3. When prompted, go to: https://github.com/login/device

4. Enter the code displayed in your terminal

5. Authorize the application

### Option B: Using SSH Keys

1. Generate SSH key:
```bash
ssh-keygen -t ed25519 -C "your_email@example.com"
```

2. Start ssh-agent:
```bash
eval "$(ssh-agent -s)"
```

3. Add your SSH key:
```bash
ssh-add ~/.ssh/id_ed25519
```

4. Add the SSH key to GitHub:
   - Copy: `cat ~/.ssh/id_ed25519.pub`
   - Go to: https://github.com/settings/keys
   - Click "New SSH key"
   - Paste the key

## Step 2: Create GitHub Repository

Once authenticated, run:
```bash
cd ~/caripropshop
gh repo create caripropshop --public --description "CariPropShop - Real Estate Website with WordPress + React"
```

Or create it manually:
1. Go to: https://github.com/new
2. Repository name: `caripropshop`
3. Description: `CariPropShop - Real Estate Website with WordPress + React`
4. Select Public
5. Do NOT initialize with README
6. Click "Create repository"

## Step 3: Initialize Git and Push

```bash
cd ~/caripropshop

# Initialize git
git init

# Configure git (replace with your info)
git config user.name "Your Name"
git config user.email "your.email@example.com"

# Add all files
git add .

# First commit
git commit -m "Initial commit: CariPropShop project setup

- WordPress structure with custom plugins directory
- React app structure
- Docker configuration
- Documentation
- CariPropShop Core plugin framework"

# Add remote
git remote add origin https://github.com/YOUR_USERNAME/caripropshop.git

# Push to GitHub
git branch -M main
git push -u origin main
```

## Step 4: Verify

Check your repository at: https://github.com/YOUR_USERNAME/caripropshop

---

## Quick Setup Script

Run this script to set up GitHub quickly:

```bash
#!/bin/bash
echo "CariPropShop GitHub Setup"
echo "========================"

# Check if gh is installed
if ! command -v gh &> /dev/null; then
    echo "Installing GitHub CLI..."
    brew install gh
fi

# Authenticate
echo "Please authenticate with GitHub:"
gh auth login

# Create repository
cd ~/caripropshop
gh repo create caripropshop --public --source=. --push

echo "Done! Repository created at: https://github.com/YOUR_USERNAME/caripropshop"
```
