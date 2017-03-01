server '185.108.181.38', user: 'root', roles: %w{web app}

# Directory to deploy
# ===================
  set :env, 'production'
  set :deploy_to, '/home/moldova-ocds/production'
  set :shared_path, '/home/moldova-ocds/production/shared'
  set :overlay_path, '/home/moldova-ocds/production/overlay'
  set :app_env, 'production'
  set :app_debug, 'false'
  set :tmp_dir, '/home/moldova-ocds/tmp'
