# config valid only for current version of Capistrano
lock '3.5.0'

set :application, 'monitoring.upro.fr'
set :repo_url, 'git@github.com:ysaid28/monitoring.git'
set :ssh_user, 'deploy'

# Default branch is :master
ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, '/var/www/management'

# Default value for :scm is :git
# set :scm, :git


# You can configure the Airbrussh format using :format_options.
# These are the defaults.
set :format_options, command_output: true, log_file: 'var/logs/capistrano.log', color: :auto, truncate: :auto

# Default value for :log_level is :debug
set :log_level, :info

# Composer
set :composer_install_flags, '--no-interaction --quiet --optimize-autoloader'

# npm
set :npm_flags, '--silent --no-progress'

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
# set :linked_files, fetch(:linked_files, []).push('config/database.yml', 'config/secrets.yml')
set :linked_files, %w{.env}


# Default value for linked_dirs is []
# set :linked_dirs, fetch(:linked_dirs, []).push('log', 'tmp/pids', 'tmp/cache', 'tmp/sockets', 'public/system')

set :linked_dirs, %w{vendor var/logs}

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
set :keep_releases, 3