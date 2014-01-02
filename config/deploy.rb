set :application, "phpguide"
 
set :scm, :git
set :git_enable_submodules, 1

set :repository,  "https://github.com/intval/phpguide.git"
set :deploy_via, :remote_cache

role :app, "54.229.193.33" # EDIT server ip address 
set :deploy_to, "/var/www/phpguide" # EDIT folder where files should be deployed
 
set :user, "deployer" 
set :use_sudo, false
set :ssh_options, {
   :forward_agent => true,
   :auth_methods => ["publickey"],
   :keys => ["/vagrant/deployer.rsa"]
}

set :keep_releases, 3
 
default_run_options[:pty] = true # needed for the password prompt from git to work
 
set :shared_assets, [
	"protected/config/config.prod.php", 
	"protected/config/dbconnection.php", 
	"protected/config/services.php", 
	"protected/runtime/application.log",
	"protected/runtime/state.bin",
	"protected/runtime/ipn.log"
]

set :copy_exclude, [
	".git", 
	".DS_Store", 
	".gitignore", 
	".gitmodules", 
	".htaccess", 
	"build.xml", 
	".nginx.conf", 
	"Readme.md",
	"Capfile"
]

set :files_to_remove, [
	"tmp",
	"log",
	"REVISION",
	"public",
	"composer.json",
	"composer.lock",
	"Gruntfile.coffee"
]




namespace :deploy do
 
   task :update do
      transaction do
         update_code # built-in function
		 preserve_shared
		 build
		 migrate
		 cleanup1
		 fixpermissions
         symlink # built-in function
      end
   end

    task :preserve_shared do
      shared_assets.each { |link| run "ln -nfs #{shared_path}/projectfiles/#{link} #{release_path}/#{link}" }
    end	

   task :build do
      transaction do
         run "cd #{current_release} && npm install && composer install -o --no-dev && grunt coffee && grunt stylus"
      end
   end

   task :cleanup1 do 
		transaction do 
			files_to_remove.each { |f| run "rm -rf #{release_path}/#{f}"}
		end
   end
 
   task :fixpermissions do 
		transaction do 
			run "chown deployer:www1 -R #{release_path} && chmod g+rw -R #{release_path}"
			run "chown deployer:www1 -R #{shared_path}/projectfiles && chmod g+rw -R #{shared_path}/projectfiles"
		end
   end

	task :migrate do
		run "cd #{current_release}/protected && php ./yiic.php migrate --interactive=0"
	end

	task :finalize_update do
	end
 
   task :restart do
      transaction do
         run "chmod -R g+rw #{releases_path}/#{release_name}"
      end
   end
 
end