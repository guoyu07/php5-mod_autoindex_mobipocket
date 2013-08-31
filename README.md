# MOBIPocket Apache AutoIndex Filter

PHP5 Apache autoindex filter for MOBIPocket files.
Requires [php5-mobipocket][mp].

[mp]: https://github.com/mrdragonraaar/php5-mobipocket

## Usage

    <IfModule mod_ext_filter.c>
        ExtFilterDefine mod_autoindex_mobipocket mode=output intype=text/html \
        cmd="/path/to/mod_autoindex_mobipocket/mod_autoindex_mobipocket.php"
    </IfModule>
    
    <Location /url/to/books>
        SetEnv no-gzip 1
        SetOutputFilter mod_autoindex_mobipocket
    </Location>

## Templates

`template_icon.php` replaces the icon in html directory listing with MOBIPocket cover.

`template_filename.php` replaces the filename in html directory listing with MOBIPocket title, author and 
icon links to metadata and text for use with [php5-mod_mobipocket][mmp].

[mmp]: https://github.com/mrdragonraaar/php5-mod_mobipocket



  
  
