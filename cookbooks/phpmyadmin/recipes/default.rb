include_recipe "apache2"
include_recipe "apache2::mod_php5"
include_recipe "mysql::client"
include_recipe "php::module_mysql"

apache_module "php5" do
  filename "libphp5.so"
end

package "phpMyAdmin3" do
  action :upgrade
end

template "config.inc.php" do
  path "/etc/phpMyAdmin/config.inc.php"
  source "config.inc.php.erb"
  owner "root"
  group "root"
  mode "0644"
end

cookbook_file "/etc/httpd/sites-available/phpMyAdmin.conf" do
  source "phpMyAdmin.conf"
  owner "root"
  group "root"
  mode "0644"
  notifies :restart, resources(:service => "apache2")
end

execute "site-enabled-phpMyAdmin" do
  command "a2ensite phpMyAdmin.conf"
end
