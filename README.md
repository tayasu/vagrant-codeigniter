VagrantとCodeIgniter
======================

Vagrant環境の作成
------------------

### VirtualBoxをインストール ###

Virtualboxのサイトからインストーラをダウンロードしてインストールする。  
<https://www.virtualbox.org>

### Vagrantをインストール ###

Vagrantのサイトからインストーラをダウンロードしてインストールする。  
<http://www.vagrantup.com>

### Vagrantを起動 ###

ルートディレクトリに移動して下記コマンドを実行する。

    cd vagrant-codeigniter
    vagrant up

### hostsの編集 ###

hostsファイルにvagrant環境のIPとサイト名を記載する。

    # Macの場合
    echo "33.33.33.99 vagrant-codeigniter.local" | sudo tee -a /etc/hosts

### Codeigniterのトップページにアクセスする ###

下記URLにアクセスするとCodeIgniterのトップページが表示される。

    http://vagrant-codeigniter.local

データベースの使い方
------------------

### MySQL ###

データベースはMySQLがインストール済みです。

ホスト: `localhost`  
ユーザー名: `root`  
パスワード: `なし`

### phpMyAdmin ###

phpMyAdminがインストール済みです。
下記のURLからアクセスできます。  
<http://vagrant-codeigniter.local/phpmyadmin/>

開発メモ
------------------

### VirtualBoxのLinuxへのログイン方法 ###

ルートディレクトリにて、下記コマンドを実行する。

    vagrant ssh

### ログの確認方法 ###

開発中にエラーが発生した場合や、CodeIgniterのlog_messageでログ出力した場合は、VirtualBoxのLinuxへログイン後、下記コマンドで確認ができる。

    #Apacheのアクセスログ
    sudo vi /var/log/httpd/vagrant-codeigniter-access_log
    
    #Apacheのエラーログ
    sudo vi /var/log/httpd/vagrant-codeigniter-error_log
    
    #CodeIgniterのログ（日ごとに作成される）
    sudo vi /var/log/vagrant-codeigniter/log-YYYY-MM-DD.php