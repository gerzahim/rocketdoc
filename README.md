# Rocketdoc

Changelog list.

- Create Project
- Create Releases version
- Add Issue Tracker 
- Integrate Jira API third party
- Create Release History
- Generated Documentation


- Nginx
- PHP 8
- MySQL
- Redis
- Node 14

## Project Folder
```
members-area/
│── Laravel app files 
│── .k8s/
│── .docker/
│    └─ database/ -> mysql data stored 
│    └─ nginx/    -> config File
│    └─ php/      -> php.ini & Dockerfile
|
└── docker-compose.yml
```

## Clone members-area Repository

```bash
cd ~/Documents/sites/
git clone git@gitlab.com:paperstreet/tsv4/rocketdoc.git
```

---

### Update .ENV file

```bash
> cd ~/Documents/sites/rocketdoc/
> cp env.example .env

# Create Personal Access Token on Jira and set variables env
JIRA_ACCOUNT=email.jira
JIRA_TOKEN=personal_access_token
JIRA_BASE_URL=https://<yourJiraHost>.atlassian.net/
```

## Build Docker Containers

```bash
cd  ~/Documents/sites/rocketdoc/

## Build Docker Images and Containers
docker-compose up -d --build --force-recreate
```

## Install Dependencies

```bash
# Enter PHP-FPM Container as regular user
docker exec -it rocket_phpfpm_container bash

# Install JavaScript
npm install 

#Compiling build js & css into production files (Not required )
npm run dev

# Install PHP Dependencies
composer install

# Generate encryption key for environment
php artisan key:generate

# running migrations, RUN SEEDERS
php artisan migrate db:fresh --seed

# logout
> exit
```
