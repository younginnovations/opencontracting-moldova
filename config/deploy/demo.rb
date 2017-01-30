server '128.199.73.92', user: 'moldova-ocds', roles: %w{web app}

# Directory to deploy
# ===================
  set :env, 'demo'
  set :deploy_to, '/home/moldova-ocds/demo'
  set :shared_path, '/home/moldova-ocds/demo/shared'
  set :overlay_path, '/home/moldova-ocds/demo/overlay'
  set :app_env, 'demo'
  set :app_debug, 'false'
  set :tmp_dir, '/home/moldova-ocds/tmp'