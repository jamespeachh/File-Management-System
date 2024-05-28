pwd
output=$(git pull)
if [ -e .env ]
then
    awk -F= '$1 == "LOCAL_PATH_TO_PROJECT" {echo $2}' .env
    if [[ "$output" == *"Already up to date."* ]]; then
        test="             ★★★      This repository is up to date.      ★★★                "
    else
            test="             ★★★              Changes made!               ★★★                "
        echo output
    fi

    echo "                    ▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄▄"
    echo "                    █ ♥ ##    ##  ######  ##       ♥ █"
    echo "                    █ ♥  ##  ##  ##    ## ##       ♥ █"
    echo "                    █ ♥   ####   ##       ##       ♥ █"
    echo "                    █ ♥    ##    ##       ##       ♥ █"
    echo "                    █ ♥    ##    ##    ## ##       ♥ █"
    echo "                    █ ♥    ##     ######  ######## ♥ █"
    echo "                    ▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀▀"
    echo "┌─────────────────────────────────────────────────────────────────────────────┐"
    echo "             ★★★  Hello!  Thank you for pulling my work!  ★★★                "
    echo "             ★★★           ☆Star me on Github!☆           ★★★                "
    echo "             ★★★        Created by Matthew Lewis          ★★★                "
    echo "             ★★★          Art by Gina Pivirotto           ★★★                "
    echo "$test"
    output=$(php artisan view:cache)
    echo "             ★★★               View Cached!               ★★★                "
    output=$(php artisan route:cache)
    echo "             ★★★             Route is Cached!             ★★★                "
    echo "└─────────────────────────────────────────────────────────────────────────────┘"
    echo "Jobs scheduled:"
    php artisan schedule:list

else
    echo "No ENV or TXT file found, please create one with the exact location of the file or run this script from inside the repository."
fi



