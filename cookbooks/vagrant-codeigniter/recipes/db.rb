include_recipe "mysql::server"

service "mysqld" do
  action :enable
end

gem_package "mysql" do
  gem_binary "/usr/local/bin/gem"
  options "--no-ri --no-rdoc"
  action :install
end

db = node['mysql']['database_name']
password = node['mysql']['server_root_password']

mysql_database db do
  connection(
    :host => "localhost",
    :username => 'root',
    :password => password
  )
  action :create
end
