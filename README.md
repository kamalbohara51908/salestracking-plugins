Magento 2 Salestracking by Möbel
===========================================

####Support
    v1.0.0 - Magento 2.2.*, 2.3.*

####Installation
    1. Download the archive.
    2. Unzip the content of archive, use command 'unzip moebel-sales-tracking-1.0.0.zip'. Now you have folder with name 'Salestracking'.
    3. Make sure to create the directory structure in your Magento - 'Magento_Root/app/code/Moebel'.
    4. Drop/move the unzipped folder to directory 'Magento_Root/app/code/Moebel'.
    5. Run the command 'php bin/magento module:enable Moebel_Salestracking' in Magento root. 
    6. Run the command 'php bin/magento setup:upgrade' in Magento root.
    7. Run the command 'php bin/magento setup:di:compile' 
    8. Run the command 'php bin/magento setup:static-content:deploy -f'
    9. Clear cache:    'php bin/magento cache:clean'
