# Upgrade Guide

This file provides notes on how to upgrade between versions.

## 2.0

### Migrations

You will need to delete the `2015_02_16_211509_create_config_table.php` migration from your application, as it
is now loaded via this package's service provider.
