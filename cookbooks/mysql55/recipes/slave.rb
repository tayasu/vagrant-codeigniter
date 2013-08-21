#
# Cookbook Name:: mysql55
# Recipe:: slave
#
# Copyright 2013, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#

# Recipe snippet applied to master DB node
ruby_block "master-log" do
  block do
    logs = %x[mysql -u #{node[:mysql55][:repl_user]} -p#{node[:mysql55][:repl_user_password]} -h #{node[:mysql55][:master_ip]} -e "show master status;" | grep bin-log].strip.split
    node.default[:mysql55][:master][:log_file] = logs[0]
    node.default[:mysql55][:master][:log_pos] = logs[1]
    Chef::Log.logger.info  node[:mysql55][:master][:log_file]
    Chef::Log.logger.info  node[:mysql55][:master][:log_pos]
  end
  action :create
end

ruby_block "import-master-log" do
  block do
    %x[mysql -u root -e "CHANGE MASTER TO \n master_host='#{node[:mysql55][:master_ip]}', \n master_port=3306, \n master_user='#{node[:mysql55][:repl_user]}', \n master_password='#{node[:mysql55][:repl_user_password]}', \n master_log_file='#{node[:mysql55][:master][:log_file]}', \n master_log_pos=#{node[:mysql55][:master][:log_pos]};"]
    %x[mysql -u root -e "START SLAVE;"]
  end
  action :create
  not_if 'mysql -u root -e "show slave status\G" | grep Seconds_Behind_Master '
end
