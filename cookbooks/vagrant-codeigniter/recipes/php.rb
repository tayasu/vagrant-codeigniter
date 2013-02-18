include_recipe "php"

target_vers = node['php']['pear_version']
unless target_vers.nil?
  current_vers = %x[ pear -V 2>&1 | grep PEAR | awk '{print $NF}' | tr -d '\n' ]
  php_pear "PEAR" do
    version = target_vers
    action :upgrade
    options "--force"
    not_if { Gem::Version.new(current_vers) == Gem::Version.new(target_vers) }
  end
end

include_recipe "phpmyadmin"
