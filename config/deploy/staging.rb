server '128.199.73.92', user: 'moldova-ocds', roles: %w{web app}

# Directory to deploy 
# ===================
  set :env, 'staging'
  set :deploy_to, '/home/moldova-ocds/staging'
  set :shared_path, '/home/moldova-ocds/staging/shared'
  set :overlay_path, '/home/moldova-ocds/overlay'
  set :app_env, 'staging'
  set :app_debug, 'false'
  set :tmp_dir, '/home/moldova-ocds/tmp'