#
# Cookbook Name:: apache
# Recipe:: mod_ssl
#
# Copyright 2013, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#

%w{ openssl mod_ssl }.each do |pkg|
  package pkg do
    action :install
  end
end

execute "apachectl configtest" do
  command "apachectl configtest"
end

execute "apachectl graceful" do
  command "apachectl graceful"
  only_if "apachectl configtest"
end

