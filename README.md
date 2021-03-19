# Challange Codes

`php artisan migrate`

`php artisan serve`

These commands should be ok to test

After them,

*/api/register* : POST : it is for the first section of wanted project "**Register**"
accepts data 
[uid, appId, lang, os, expiry, token]
response data
the same

*/api/checkReceipt* : GET : it is for the second section of wanted project "**Purchase**"
accepts data
[receipt, clientToken]
response data
[receipt, clientToken, status, expireDate]

*/api/checkSubscription* : GET : it is for the third section of wanted project "**Check Subscription**"
accepts data
[token]
response data
DB Row of Subscriber Device Data

*/api/verifyReceipt* : GET : it is for mocking of Google and iOS API services at the second section of wanted project "**Purchase**"
accepts data
[receipt]
response data
[status, expireDate]

