include_recipe "mysql55"

db = node['mysql']['database_name']
password = node['mysql']['server_root_password']

bash "mysql-create-database" do
  code <<-EOC
    echo 'CREATE DATABASE IF NOT EXISTS #{db};' | /usr/bin/mysql -u root #{password.empty? ? '' : '-p' }#{password} --default-character-set=utf8
  EOC
end
