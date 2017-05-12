server '185.108.181.38', user: 'root', roles: %w{web app}

# Directory to deploy 
# ===================
  set :env, 'staging'
  set :deploy_to, '/home/moldova-ocds/staging'
  set :shared_path, '/home/moldova-ocds/staging/shared'
  set :overlay_path, '/home/moldova-ocds/staging/overlay'
  set :app_env, 'staging'
  set :app_debug, 'false'
  set :tmp_dir, '/home/moldova-ocds/tmp'
