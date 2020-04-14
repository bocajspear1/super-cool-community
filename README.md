# Super Cool Community

## Not finished...

Uh, made this is a few days and probably not ready for production use. It might be a bit vulnerable...

## Setup

Use the `install.php` script to help setup your community and its config.

## Admin

Use the `admin.php` page to administer your community. The username and password for the admin page are in the config file.

## SQL 

SQL is in the `sccommunity.sql` file.

## Troubleshooting

Having trouble with writing your `config.json` file? Are you on Centos? Try this config to change SELinux: 

```
chcon -Rv --type=httpd_sys_rw_content_t /var/www/html/
```