<IfModule mod_rewrite.c>
Options +FollowSymLinks
RewriteEngine on

RewriteCond %{HTTP_HOST} ^{host_sin_www}$ [NC]
RewriteRule ^(.*)$ http://{host}/$1 [L,R=301]

RewriteCond %{REQUEST_URI}  !\.(php?|html?|jpg|png|bmp|gif|svg|js|css|ttf|woff|xml|txt|swf|jar|zip|kml|eot|json|pdf|ico|mp4|ogg|webm)$
RewriteRule ^(.*)([^/])$ http://%{HTTP_HOST}/$1$2/ [L,R=301]


RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?my_url_friendly=$1 [L,QSA]

Options -MultiViews

</IfModule>




<IfModule mod_expires.c>
ExpiresActive on

# Perhaps better to whitelist expires rules? Perhaps.
ExpiresDefault                          "access plus 1 month"

# cache.appcache needs re-requests in FF 3.6 (thx Remy ~Introducing HTML5)
ExpiresByType text/cache-manifest       "access plus 0 seconds"

# your document html
ExpiresByType text/html                 "access plus 0 seconds"

# data
ExpiresByType text/xml                  "access plus 0 seconds"
ExpiresByType application/xml           "access plus 0 seconds"
ExpiresByType application/json          "access plus 0 seconds"

# rss feed
ExpiresByType application/rss+xml       "access plus 1 hour"

# favicon (cannot be renamed)
ExpiresByType image/x-icon              "access plus 1 week"

# media: images, video, audio
ExpiresByType image/gif                 "access plus 1 month"
ExpiresByType image/png                 "access plus 1 month"
ExpiresByType image/jpg                 "access plus 1 month"
ExpiresByType image/jpeg                "access plus 1 month"
ExpiresByType video/ogg                 "access plus 1 month"
ExpiresByType audio/ogg                 "access plus 1 month"
ExpiresByType video/mp4                 "access plus 1 month"
ExpiresByType video/webm                "access plus 1 month"

# htc files  (css3pie)
ExpiresByType text/x-component          "access plus 1 month"

# webfonts
ExpiresByType font/truetype             "access plus 1 month"
ExpiresByType font/opentype             "access plus 1 month"
ExpiresByType application/x-font-woff   "access plus 1 month"
ExpiresByType image/svg+xml             "access plus 1 month"
ExpiresByType application/vnd.ms-fontobject "access plus 1 month"

# css and javascript
ExpiresByType text/css                  "access plus 2 months"
ExpiresByType application/javascript    "access plus 2 months"
ExpiresByType text/javascript           "access plus 2 months"

<IfModule mod_headers.c>
Header append Cache-Control "public"
</IfModule>

</IfModule>
# BEGIN W3TC Browser Cache
<IfModule mod_deflate.c>
<IfModule mod_headers.c>
Header append Vary User-Agent env=!dont-vary
</IfModule>
AddOutputFilterByType DEFLATE text/css text/x-component application/x-javascript application/javascript text/javascript text/x-js text/html text/richtext image/svg+xml text/plain text/xsd text/xsl text/xml image/x-icon application/json
<IfModule mod_mime.c>
# DEFLATE by extension
AddOutputFilter DEFLATE js css htm html xml
</IfModule>
</IfModule>
