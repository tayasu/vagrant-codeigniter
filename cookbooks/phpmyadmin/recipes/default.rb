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

cookbook_file "/etc/httpd/conf.d/phpMyAdmin.conf" do
  source "phpMyAdmin.conf"
  owner "root"
  group "root"
  mode "0644"
  notifies :restart, resources(:service => "httpd")
end
