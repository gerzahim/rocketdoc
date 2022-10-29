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
rocketdoc/        # Laravel app files 
│── .k8s/         # Manifests files for Kubernetes 
│── .docker/      # Doker files
│    └─ database/ # mysql data stored 
│    └─ nginx/    # Config File
│    └─ php/      # php.ini & Dockerfile
│
│
└── docker-compose.yml # Generate Docker Local Environment
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

## Setup Kubernetes

```bash
# Setup docker login
# Setup imagePullSecrets and regcred (Docker Login credentials)
https://www.ibm.com/docs/en/cloud-private/3.2.0?topic=images-creating-imagepullsecrets-specific-namespace
https://wp.huangshiyang.com/pull-image-from-private-registry
https://kubernetes.io/docs/tasks/configure-pod-container/pull-image-private-registry/

# Publish Image 
## docker login registry.example.com -u <username> -p <token>
> docker login registry.gitlab.com/rasce88/test-k8s -u rasce88 -p glpat-1cbarPGv2PVHwLuwRv7i

## docker build -t <registry.path> <directory.dockerfile>
## docker build -t registry.gitlab.com/rasce88/rocketdoc .
> docker build -t registry.gitlab.com/rasce88/rocketdoc .docker/php/


# Deploying Laravel in Kubernetes
> kubectl run rocketdoc-app \
  --restart=Never \
  --image=registry.gitlab.com/rasce88/rocketdoc \
  --port=80 \
  --env=APP_KEY=base64:3nP/S2oNbZubniYxlnHkuHsyoR41jvGtS651JTO0mw8=


# Create service 
> kubectl expose pods rocketdoc-app --type=NodePort --port=80
# service "rocketdoc-app" exposed

# Create Deployment 
kubectl apply -f .k8s/manifest/deployment.yaml

# Scale App 
> kubectl scale --replicas=3 deployment/rocketdoc-app 
~# deployment.apps/rocketdoc-app scaled

# create a service with:
> kubectl expose pods laravel-kubernetes-demo --type=NodePort --port=80
$ service "laravel-kubernetes-demo" exposed

kubectl apply -f .k8s/manifest/service.yaml

kubectl apply -f .k8s/manifest/ingress.yaml


```