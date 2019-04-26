# set :deploy_config_path, 'capistrano/config.rb'
# set :stage_config_path, 'capistrano/stages/'

# Load DSL and set up stages
require 'capistrano/setup'

# Include default deployment tasks
require 'capistrano/deploy'

# Include tasks from other gems included in your Gemfile
require 'capistrano/file-permissions'
require 'capistrano/composer'
require 'capistrano/symfony'
require 'capistrano/npm'

# Load custom tasks from `capistrano/tasks` if you have any defined
Dir.glob('capistrano/tasks/*.rake').each { |r| import r }
