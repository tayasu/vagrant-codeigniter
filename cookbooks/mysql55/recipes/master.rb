#
# Cookbook Name:: mysql55
# Recipe:: master
#
# Copyright 2013, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#

node[:mysql55][:slave_ip].each do |slave_ip|
  execute "add-mysql-user-#{node[:mysql55][:repl_user]}" do
    command "/usr/bin/mysql -u root -D mysql -r -B -N -e \"GRANT REPLICATION SLAVE, REPLICATION CLIENT ON *.* TO '#{node[:mysql55][:repl_user]}'@'#{slave_ip}' IDENTIFIED BY '#{node[:mysql55][:repl_user_password]}'\""
    action :run
    only_if { `/usr/bin/mysql -u root -D mysql -r -B -N -e \"SELECT COUNT(*) FROM user where User='#{node[:mysql55][:repl_user]}' and Host = '#{slave_ip}'"`.to_i == 0 }
  end
end
