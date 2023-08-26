@if ($artifactable!=null)
   
    <a id="{{$control_id}}_btn_icon_selector" href="#" 
        data-val-artifactable-id="{{$artifactable->id}}"
        data-val-artifactable-name="{{$artifactable_label}}"
        data-val-artifactable-class="{{get_class($artifactable)}}"
        style="font-size:80%" class="ms-auto small btn-show-icon-selector-upload {{$button_class}}">
        {{$button_label}}
    </a>

    @php
        $fa_icons = [];
        $li_icons = ["lni lni-500px","lni lni-adobe","lni lni-agenda","lni lni-airbnb","lni lni-alarm","lni lni-alarm-clock","lni lni-amazon","lni lni-amazon-original","lni lni-amazon-pay","lni lni-ambulance","lni lni-amex","lni lni-anchor","lni lni-android","lni lni-android-original","lni lni-angellist","lni lni-angle-double-down","lni lni-angle-double-left","lni lni-angle-double-right","lni lni-angle-double-up","lni lni-angular","lni lni-apartment","lni lni-app-store","lni lni-apple","lni lni-apple-pay","lni lni-archive","lni lni-arrow-down","lni lni-arrow-down-circle","lni lni-arrow-left","lni lni-arrow-left-circle","lni lni-arrow-right","lni lni-arrow-right-circle","lni lni-arrow-top-left","lni lni-arrow-top-right","lni lni-arrow-up","lni lni-arrow-up-circle","lni lni-arrows-horizontal","lni lni-arrows-vertical","lni lni-atlassian","lni lni-aws","lni lni-backward","lni lni-baloon","lni lni-ban","lni lni-bar-chart","lni lni-basketball","lni lni-behance","lni lni-behance-original","lni lni-bi-cycle","lni lni-bitbucket","lni lni-bitcoin","lni lni-blackboard","lni lni-blogger","lni lni-bluetooth","lni lni-bold","lni lni-bolt","lni lni-bolt-alt","lni lni-book","lni lni-bookmark","lni lni-bookmark-alt","lni lni-bootstrap","lni lni-bricks","lni lni-bridge","lni lni-briefcase","lni lni-brush","lni lni-brush-alt","lni lni-bubble","lni lni-bug","lni lni-bulb","lni lni-bullhorn","lni lni-burger","lni lni-bus","lni lni-cake","lni lni-calculator","lni lni-calendar","lni lni-camera","lni lni-candy","lni lni-candy-cane","lni lni-capsule","lni lni-car","lni lni-car-alt","lni lni-caravan","lni lni-cart","lni lni-cart-full","lni lni-certificate","lni lni-checkbox","lni lni-checkmark","lni lni-checkmark-circle","lni lni-chef-hat","lni lni-chevron-down","lni lni-chevron-down-circle","lni lni-chevron-left","lni lni-chevron-left-circle","lni lni-chevron-right","lni lni-chevron-right-circle","lni lni-chevron-up","lni lni-chevron-up-circle","lni lni-chrome","lni lni-circle-minus","lni lni-circle-plus","lni lni-clipboard","lni lni-close","lni lni-cloud","lni lni-cloud-check","lni lni-cloud-download","lni lni-cloud-network","lni lni-cloud-sync","lni lni-cloud-upload","lni lni-cloudy-sun","lni lni-code","lni lni-code-alt","lni lni-codepen","lni lni-coffee-cup","lni lni-cog","lni lni-cogs","lni lni-coin","lni lni-comments","lni lni-comments-alt","lni lni-comments-reply","lni lni-compass","lni lni-construction","lni lni-construction-hammer","lni lni-consulting","lni lni-control-panel","lni lni-cpanel","lni lni-creative-commons","lni lni-credit-cards","lni lni-crop","lni lni-cross-circle","lni lni-crown","lni lni-css3","lni lni-cup","lni lni-customer","lni lni-cut","lni lni-dashboard","lni lni-database","lni lni-delivery","lni lni-dev","lni lni-diamond","lni lni-diamond-alt","lni lni-diners-club","lni lni-dinner","lni lni-direction","lni lni-direction-alt","lni lni-direction-ltr","lni lni-direction-rtl","lni lni-discord","lni lni-discover","lni lni-display","lni lni-display-alt","lni lni-docker","lni lni-dollar","lni lni-domain","lni lni-download","lni lni-dribbble","lni lni-drop","lni lni-dropbox","lni lni-dropbox-original","lni lni-drupal","lni lni-drupal-original","lni lni-dumbbell","lni lni-edge","lni lni-emoji-cool","lni lni-emoji-friendly","lni lni-emoji-happy","lni lni-emoji-sad","lni lni-emoji-smile","lni lni-emoji-speechless","lni lni-emoji-suspect","lni lni-emoji-tounge","lni lni-empty-file","lni lni-enter","lni lni-envato","lni lni-envelope","lni lni-eraser","lni lni-euro","lni lni-exit","lni lni-exit-down","lni lni-exit-up","lni lni-eye","lni lni-facebook","lni lni-facebook-filled","lni lni-facebook-messenger","lni lni-facebook-original","lni lni-facebook-oval","lni lni-figma","lni lni-files","lni lni-firefox","lni lni-firefox-original","lni lni-fireworks","lni lni-first-aid","lni lni-flag","lni lni-flag-alt","lni lni-flags","lni lni-flickr","lni lni-flower","lni lni-folder","lni lni-forward","lni lni-frame-expand","lni lni-fresh-juice","lni lni-full-screen","lni lni-funnel","lni lni-gallery","lni lni-game","lni lni-gift","lni lni-git","lni lni-github","lni lni-github-original","lni lni-goodreads","lni lni-google","lni lni-google-drive","lni lni-google-pay","lni lni-google-wallet","lni lni-graduation","lni lni-graph","lni lni-grid","lni lni-grid-alt","lni lni-grow","lni lni-hacker-news","lni lni-hammer","lni lni-hand","lni lni-handshake","lni lni-harddrive","lni lni-headphone","lni lni-headphone-alt","lni lni-heart","lni lni-heart-filled","lni lni-heart-monitor","lni lni-helicopter","lni lni-helmet","lni lni-help","lni lni-highlight","lni lni-highlight-alt","lni lni-home","lni lni-hospital","lni lni-hourglass","lni lni-html5","lni lni-image","lni lni-inbox","lni lni-indent-decrease","lni lni-indent-increase","lni lni-infinite","lni lni-information","lni lni-instagram","lni lni-instagram-filled","lni lni-instagram-original","lni lni-invention","lni lni-invest-monitor","lni lni-investment","lni lni-island","lni lni-italic","lni lni-java","lni lni-javascript","lni lni-jcb","lni lni-joomla","lni lni-joomla-original","lni lni-jsfiddle","lni lni-juice","lni lni-key","lni lni-keyboard","lni lni-keyword-research","lni lni-laptop","lni lni-laptop-phone","lni lni-laravel","lni lni-layers","lni lni-layout","lni lni-leaf","lni lni-library","lni lni-life-ring","lni lni-line","lni lni-line-dashed","lni lni-line-dotted","lni lni-line-double","lni lni-line-spacing","lni lni-lineicons","lni lni-lineicons-alt","lni lni-link","lni lni-linkedin","lni lni-linkedin-original","lni lni-list","lni lni-lock","lni lni-lock-alt","lni lni-magnet","lni lni-magnifier","lni lni-mailchimp","lni lni-map","lni lni-map-marker","lni lni-mashroom","lni lni-mastercard","lni lni-medium","lni lni-megento","lni lni-menu","lni lni-mic","lni lni-microphone","lni lni-microscope","lni lni-microsoft","lni lni-minus","lni lni-mobile","lni lni-money-location","lni lni-money-protection","lni lni-more","lni lni-more-alt","lni lni-mouse","lni lni-move","lni lni-music","lni lni-network","lni lni-night","lni lni-nodejs","lni lni-nodejs-alt","lni lni-notepad","lni lni-npm","lni lni-offer","lni lni-opera","lni lni-package","lni lni-page-break","lni lni-pagination","lni lni-paint-bucket","lni lni-paint-roller","lni lni-pallet","lni lni-paperclip","lni lni-patreon","lni lni-pause","lni lni-paypal","lni lni-paypal-original","lni lni-pencil","lni lni-pencil-alt","lni lni-phone","lni lni-phone-set","lni lni-php","lni lni-pie-chart","lni lni-pilcrow","lni lni-pin","lni lni-pinterest","lni lni-pizza","lni lni-plane","lni lni-play","lni lni-play-store","lni lni-plug","lni lni-plus","lni lni-pointer","lni lni-pointer-down","lni lni-pointer-left","lni lni-pointer-right","lni lni-pointer-up","lni lni-popup","lni lni-postcard","lni lni-pound","lni lni-power-switch","lni lni-printer","lni lni-producthunt","lni lni-protection","lni lni-pulse","lni lni-pyramids","lni lni-python","lni lni-question-circle","lni lni-quora","lni lni-quotation","lni lni-radio-button","lni lni-rain","lni lni-react","lni lni-reddit","lni lni-reload","lni lni-remove-file","lni lni-reply","lni lni-restaurant","lni lni-revenue","lni lni-road","lni lni-rocket","lni lni-rss-feed","lni lni-ruler","lni lni-ruler-alt","lni lni-ruler-pencil","lni lni-rupee","lni lni-save","lni lni-school-bench","lni lni-school-bench-alt","lni lni-scooter","lni lni-scroll-down","lni lni-search","lni lni-search-alt","lni lni-select","lni lni-seo","lni lni-service","lni lni-share","lni lni-share-alt","lni lni-shield","lni lni-shift-left","lni lni-shift-right","lni lni-ship","lni lni-shopify","lni lni-shopping-basket","lni lni-shortcode","lni lni-shovel","lni lni-shuffle","lni lni-signal","lni lni-sketch","lni lni-skipping-rope","lni lni-skype","lni lni-slack","lni lni-slice","lni lni-slideshare","lni lni-slim","lni lni-snapchat","lni lni-sort-alpha-asc","lni lni-sort-amount-asc","lni lni-sort-amount-dsc","lni lni-souncloud-original","lni lni-soundcloud","lni lni-spellcheck","lni lni-spiner-solid","lni lni-spinner","lni lni-spinner-arrow","lni lni-spotify","lni lni-spotify-original","lni lni-spray","lni lni-sprout","lni lni-stackoverflow","lni lni-stamp","lni lni-star","lni lni-star-empty","lni lni-star-filled","lni lni-star-half","lni lni-stats-down","lni lni-stats-up","lni lni-steam","lni lni-sthethoscope","lni lni-stop","lni lni-strikethrough","lni lni-stripe","lni lni-stumbleupon","lni lni-sun","lni lni-support","lni lni-surf-board","lni lni-swift","lni lni-syringe","lni lni-tab","lni lni-tag","lni lni-target","lni lni-target-customer","lni lni-target-revenue","lni lni-taxi","lni lni-teabag","lni lni-telegram","lni lni-telegram-original","lni lni-text-align-center","lni lni-text-align-justify","lni lni-text-align-left","lni lni-text-align-right","lni lni-text-format","lni lni-text-format-remove","lni lni-thought","lni lni-thumbs-down","lni lni-thumbs-up","lni lni-thunder","lni lni-thunder-alt","lni lni-ticket","lni lni-ticket-alt","lni lni-timer","lni lni-train","lni lni-train-alt","lni lni-trash","lni lni-travel","lni lni-tree","lni lni-trees","lni lni-trello","lni lni-trowel","lni lni-tshirt","lni lni-tumblr","lni lni-twitch","lni lni-twitter","lni lni-twitter-filled","lni lni-twitter-original","lni lni-ubuntu","lni lni-underline","lni lni-unlink","lni lni-unlock","lni lni-upload","lni lni-user","lni lni-users","lni lni-ux","lni lni-vector","lni lni-video","lni lni-vimeo","lni lni-visa","lni lni-vk","lni lni-volume","lni lni-volume-high","lni lni-volume-low","lni lni-volume-medium","lni lni-volume-mute","lni lni-wallet","lni lni-warning","lni lni-website","lni lni-website-alt","lni lni-wechat","lni lni-weight","lni lni-whatsapp","lni lni-wheelbarrow","lni lni-wheelchair","lni lni-windows","lni lni-wordpress","lni lni-wordpress-filled","lni lni-world","lni lni-world-alt","lni lni-write","lni lni-yahoo","lni lni-ycombinator","lni lni-yen","lni lni-youtube","lni lni-zip","lni lni-zoom-in","lni lni-zoom-out"];
        $bx_icons = ["bx bx-shape-polygon","bx bx-donate-blood","bx bx-donate-heart","bx bx-door-open","bx bx-credit-card-front","bx bx-cookie","bx bx-comment-detail","bx bx-comment-add","bx bx-comment-minus","bx bx-comment-edit","bx bx-comment-x","bx bx-comment-error","bx bx-comment-check","bx bx-message-square-detail","bx bx-message-square-add","bx bx-message-square-edit","bx bx-message-square-minus","bx bx-message-square-x","bx bx-message-square-error","bx bx-message-square-check","bx bx-message-detail","bx bx-message-add","bx bx-message-edit","bx bx-message-minus","bx bx-message-x","bx bx-message-error","bx bx-message-check","bx bx-message-rounded-detail","bx bx-message-rounded-add","bx bx-message-rounded-edit","bx bx-message-rounded-minus","bx bx-message-rounded-x","bx bx-message-rounded-error","bx bx-message-rounded-check","bx bx-message-alt-detail","bx bx-message-alt-edit","bx bx-message-alt-minus","bx bx-message-alt-x","bx bx-message-alt-error","bx bx-message-alt-check","bx bx-message-alt-add","bx bx-envelope-open","bx bx-home-smile","bx bx-refresh","bx bx-meteor","bx bx-outline","bx bx-trim","bx bx-merge","bx bx-minus-back","bx bx-exclude","bx bx-intersect","bx bx-minus-front","bx bx-unite","bx bx-coin-stack","bx bx-coin","bx bx-church","bx bx-chevron-right-square","bx bx-chevron-left-square","bx bx-chevron-up-square","bx bx-chevron-down-square","bx bx-chevron-right-circle","bx bx-chevron-left-circle","bx bx-chevron-up-circle","bx bx-chevron-down-circle","bx bx-line-chart-down","bx bx-shield-x","bx bx-caret-down-square","bx bx-caret-left-square","bx bx-caret-up-square","bx bx-caret-right-square","bx bx-caret-down-circle","bx bx-caret-up-circle","bx bx-caret-left-circle","bx bx-caret-right-circle","bx bx-camera-movie","bx bx-camera-home","bx bx-calendar-star","bx bx-calendar-exclamation","bx bx-vector","bx bx-network-chart","bx bx-chair","bx bx-cctv","bx bx-drink","bx bx-eraser","bx bx-capsule","bx bx-color-fill","bx bx-vial","bx bx-wine","bx bx-calendar-heart","bx bx-window-alt","bx bx-braille","bx bx-border-outer","bx bx-brain","bx bx-bracket","bx bx-book-add","bx bx-book-heart","bx bx-book-alt","bx bx-bong","bx bx-bone","bx bx-blanket","bx bx-barcode-reader","bx bx-task-x","bx bx-medal","bx bx-alarm-exclamation","bx bx-alarm-snooze","bx bx-abacus","bx bx-game","bx bx-tachometer","bx bx-sticker","bx bx-spray-can","bx bx-webcam","bx bx-dice-6","bx bx-dice-5","bx bx-dice-4","bx bx-dice-3","bx bx-dice-2","bx bx-dice-1","bx bx-border-inner","bx bx-border-none","bx bx-glasses-alt","bx bx-glasses","bx bx-calendar-week","bx bx-scan","bx bx-book-reader","bx bx-arrow-to-bottom","bx bx-arrow-to-top","bx bx-arrow-to-left","bx bx-arrow-to-right","bx bx-arrow-from-right","bx bx-arrow-from-left","bx bx-arrow-from-bottom","bx bx-arrow-from-top","bx bx-current-location","bx bx-been-here","bx bx-low-vision","bx bx-mask","bx bx-wifi-0","bx bx-wifi-1","bx bx-wifi-2","bx bx-traffic-cone","bx bx-recycle","bx bx-layer-minus","bx bx-layer-plus","bx bx-info-square","bx bx-home-heart","bx bx-heart-square","bx bx-heart-circle","bx bx-microchip","bx bx-pointer","bx bx-coffee-togo","bx bx-calendar-edit","bx bx-cabinet","bx bx-bus-school","bx bx-bomb","bx bx-bible","bx bx-beer","bx bx-baseball","bx bx-atom","bx bx-arch","bx bx-location-plus","bx bx-shape-triangle","bx bx-shape-square","bx bx-video-recording","bx bx-notepad","bx bx-bug-alt","bx bx-mouse-alt","bx bx-edit-alt","bx bx-chat","bx bx-book-content","bx bx-message-square-dots","bx bx-message-square","bx bx-slideshow","bx bx-wallet-alt","bx bx-memory-card","bx bx-message-rounded-dots","bx bx-message-dots","bx bx-bar-chart-alt-2","bx bx-store-alt","bx bx-buildings","bx bx-home-circle","bx bx-money","bx bx-walk","bx bx-repeat","bx bx-font-family","bx bx-joystick-button","bx bx-paint","bx bx-unlink","bx bx-brush","bx bx-rotate-left","bx bx-badge-check","bx bx-show-alt","bx bx-caret-down","bx bx-caret-right","bx bx-caret-up","bx bx-caret-left","bx bx-calendar-event","bx bx-magnet","bx bx-rewind-circle","bx bx-card","bx bx-help-circle","bx bx-test-tube","bx bx-note","bx bx-sort-down","bx bx-sort-up","bx bx-id-card","bx bx-badge","bx bx-grid-small","bx bx-grid-vertical","bx bx-grid-horizontal","bx bx-move-vertical","bx bx-move-horizontal","bx bx-stats","bx bx-equalizer","bx bx-disc","bx bx-analyse","bx bx-search-alt","bx bx-dollar-circle","bx bx-football","bx bx-ball","bx bx-circle","bx bx-transfer","bx bx-fingerprint","bx bx-font-color","bx bx-highlight","bx bx-file-blank","bx bx-strikethrough","bx bx-photo-album","bx bx-code-block","bx bx-font-size","bx bx-handicap","bx bx-dialpad","bx bx-wind","bx bx-water","bx bx-swim","bx bx-restaurant","bx bx-box","bx bx-menu-alt-right","bx bx-menu-alt-left","bx bx-video-plus","bx bx-list-ol","bx bx-planet","bx bx-hotel","bx bx-movie","bx bx-taxi","bx bx-train","bx bx-bath","bx bx-bed","bx bx-area","bx bx-bot","bx bx-dumbbell","bx bx-check-double","bx bx-bus","bx bx-check-circle","bx bx-rocket","bx bx-certification","bx bx-slider-alt","bx bx-sad","bx bx-meh","bx bx-happy","bx bx-cart-alt","bx bx-car","bx bx-loader-alt","bx bx-loader-circle","bx bx-wrench","bx bx-alarm-off","bx bx-layout","bx bx-dock-left","bx bx-dock-top","bx bx-dock-right","bx bx-dock-bottom","bx bx-world","bx bx-selection","bx bx-paper-plane","bx bx-slider","bx bx-loader","bx bx-chalkboard","bx bx-trash-alt","bx bx-grid-alt","bx bx-command","bx bx-window-close","bx bx-notification-off","bx bx-plug","bx bx-infinite","bx bx-carousel","bx bx-hourglass","bx bx-briefcase-alt","bx bx-wallet","bx bx-station","bx bx-collection","bx bx-tv","bx bx-closet","bx bx-paperclip","bx bx-expand","bx bx-pen","bx bx-purchase-tag","bx bx-images","bx bx-pie-chart-alt","bx bx-news","bx bx-downvote","bx bx-upvote","bx bx-globe-alt","bx bx-store","bx bx-hdd","bx bx-skip-previous-circle","bx bx-skip-next-circle","bx bx-chip","bx bx-cast","bx bx-body","bx bx-phone-outgoing","bx bx-phone-incoming","bx bx-collapse","bx bx-rename","bx bx-rotate-right","bx bx-horizontal-center","bx bx-ruler","bx bx-import","bx bx-calendar-alt","bx bx-battery","bx bx-server","bx bx-task","bx bx-folder-open","bx bx-film","bx bx-aperture","bx bx-phone-call","bx bx-up-arrow","bx bx-undo","bx bx-timer","bx bx-support","bx bx-subdirectory-right","bx bx-subdirectory-left","bx bx-right-arrow","bx bx-revision","bx bx-repost","bx bx-reply","bx bx-reply-all","bx bx-redo","bx bx-radar","bx bx-poll","bx bx-list-check","bx bx-like","bx bx-left-arrow","bx bx-joystick-alt","bx bx-history","bx bx-flag","bx bx-first-aid","bx bx-export","bx bx-down-arrow","bx bx-dislike","bx bx-crown","bx bx-barcode","bx bx-user","bx bx-user-x","bx bx-user-plus","bx bx-user-minus","bx bx-user-circle","bx bx-user-check","bx bx-underline","bx bx-trophy","bx bx-trash","bx bx-text","bx bx-sun","bx bx-star","bx bx-sort","bx bx-shuffle","bx bx-shopping-bag","bx bx-shield","bx bx-shield-alt","bx bx-share","bx bx-share-alt","bx bx-select-multiple","bx bx-screenshot","bx bx-save","bx bx-pulse","bx bx-power-off","bx bx-plus","bx bx-pin","bx bx-pencil","bx bx-paste","bx bx-paragraph","bx bx-package","bx bx-notification","bx bx-shield-quarter","bx bx-move","bx bx-mouse","bx bx-minus","bx bx-microphone-off","bx bx-log-out","bx bx-log-in","bx bx-link-external","bx bx-joystick","bx bx-italic","bx bx-home-alt","bx bx-heading","bx bx-hash","bx bx-group","bx bx-git-repo-forked","bx bx-git-pull-request","bx bx-git-merge","bx bx-git-compare","bx bx-git-commit","bx bx-git-branch","bx bx-font","bx bx-filter","bx bx-file","bx bx-edit","bx bx-diamond","bx bx-detail","bx bx-cut","bx bx-cube","bx bx-crop","bx bx-credit-card","bx bx-columns","bx bx-cog","bx bx-cloud-snow","bx bx-cloud-rain","bx bx-cloud-lightning","bx bx-cloud-light-rain","bx bx-cloud-drizzle","bx bx-check","bx bx-cart","bx bx-calculator","bx bx-bold","bx bx-award","bx bx-anchor","bx bx-album","bx bx-adjust","bx bx-x","bx bx-table","bx bx-duplicate","bx bx-windows","bx bx-window","bx bx-window-open","bx bx-wifi","bx bx-voicemail","bx bx-video-off","bx bx-usb","bx bx-upload","bx bx-alarm","bx bx-tennis-ball","bx bx-target-lock","bx bx-tag","bx bx-tab","bx bx-spreadsheet","bx bx-sitemap","bx bx-sidebar","bx bx-send","bx bx-pie-chart","bx bx-phone","bx bx-navigation","bx bx-mobile","bx bx-mobile-alt","bx bx-message","bx bx-message-rounded","bx bx-map","bx bx-map-alt","bx bx-lock","bx bx-lock-open","bx bx-list-minus","bx bx-list-ul","bx bx-list-plus","bx bx-link","bx bx-link-alt","bx bx-layer","bx bx-laptop","bx bx-home","bx bx-heart","bx bx-headphone","bx bx-devices","bx bx-globe","bx bx-gift","bx bx-envelope","bx bx-download","bx bx-dots-vertical","bx bx-dots-vertical-rounded","bx bx-dots-horizontal","bx bx-dots-horizontal-rounded","bx bx-dollar","bx bx-directions","bx bx-desktop","bx bx-data","bx bx-compass","bx bx-crosshair","bx bx-terminal","bx bx-cloud","bx bx-cloud-upload","bx bx-cloud-download","bx bx-chart","bx bx-calendar","bx bx-calendar-x","bx bx-calendar-minus","bx bx-calendar-check","bx bx-calendar-plus","bx bx-buoy","bx bx-bulb","bx bx-bluetooth","bx bx-bug","bx bx-building","bx bx-broadcast","bx bx-briefcase","bx bx-bookmark-plus","bx bx-bookmark-minus","bx bx-book","bx bx-book-bookmark","bx bx-block","bx bx-basketball","bx bx-bar-chart","bx bx-bar-chart-square","bx bx-bar-chart-alt","bx bx-at","bx bx-archive","bx bx-zoom-out","bx bx-zoom-in","bx bx-x-circle","bx bx-volume","bx bx-volume-mute","bx bx-volume-low","bx bx-volume-full","bx bx-video","bx bx-vertical-center","bx bx-up-arrow-circle","bx bx-trending-up","bx bx-trending-down","bx bx-toggle-right","bx bx-toggle-left","bx bx-time","bx bx-sync","bx bx-stopwatch","bx bx-stop","bx bx-stop-circle","bx bx-skip-previous","bx bx-skip-next","bx bx-show","bx bx-search","bx bx-rss","bx bx-right-top-arrow-circle","bx bx-right-indent","bx bx-right-down-arrow-circle","bx bx-right-arrow-circle","bx bx-reset","bx bx-rewind","bx bx-rectangle","bx bx-radio-circle","bx bx-radio-circle-marked","bx bx-question-mark","bx bx-plus-circle","bx bx-play","bx bx-play-circle","bx bx-pause","bx bx-pause-circle","bx bx-moon","bx bx-minus-circle","bx bx-microphone","bx bx-menu","bx bx-left-top-arrow-circle","bx bx-left-indent","bx bx-left-down-arrow-circle","bx bx-left-arrow-circle","bx bx-last-page","bx bx-key","bx bx-align-justify","bx bx-info-circle","bx bx-image","bx bx-hide","bx bx-fullscreen","bx bx-folder","bx bx-folder-plus","bx bx-folder-minus","bx bx-first-page","bx bx-fast-forward","bx bx-fast-forward-circle","bx bx-exit-fullscreen","bx bx-error","bx bx-error-circle","bx bx-down-arrow-circle","bx bx-copyright","bx bx-copy","bx bx-coffee","bx bx-code","bx bx-code-curly","bx bx-clipboard","bx bx-chevrons-left","bx bx-chevrons-right","bx bx-chevrons-up","bx bx-chevrons-down","bx bx-chevron-right","bx bx-chevron-left","bx bx-chevron-up","bx bx-chevron-down","bx bx-checkbox-square","bx bx-checkbox","bx bx-checkbox-checked","bx bx-captions","bx bx-camera","bx bx-camera-off","bx bx-bullseye","bx bx-bookmarks","bx bx-bookmark","bx bx-bell","bx bx-bell-plus","bx bx-bell-off","bx bx-bell-minus","bx bx-arrow-back","bx bx-align-right","bx bx-align-middle","bx bx-align-left","bx bx-music","bx bx-upside-down","bx bx-laugh","bx bx-meh-blank","bx bx-happy-beaming","bx bx-shocked","bx bx-sleepy","bx bx-confused","bx bx-wink-smile","bx bx-dizzy","bx bx-happy-heart-eyes","bx bx-angry","bx bx-smile","bx bx-tired","bx bx-cool","bx bx-happy-alt","bx bx-wink-tongue","bx bx-meh-alt","bx bx-food-menu","bx bx-food-tag","bx bx-female-sign","bx bx-male-sign","bx bx-female","bx bx-male","bx bx-clinic","bx bx-health","bx bx-shekel","bx bx-yen","bx bx-won","bx bx-pound","bx bx-euro","bx bx-rupee","bx bx-ruble","bx bx-lira","bx bx-bitcoin","bx bx-tone","bx bx-bolt-circle","bx bx-cake","bx bx-spa","bx bx-dish","bx bx-fridge","bx bx-image-add","bx bx-image-alt","bx bx-space-bar","bx bx-alarm-add","bx bx-archive-out","bx bx-archive-in","bx bx-add-to-queue","bx bx-border-radius","bx bx-check-shield","bx bx-label","bx bx-file-find","bx bx-face","bx bx-extension","bx bx-exit","bx bx-conversation","bx bx-sort-z-a","bx bx-sort-a-z","bx bx-printer","bx bx-radio","bx bx-customize","bx bx-brush-alt","bx bx-briefcase-alt-2","bx bx-time-five","bx bx-pie-chart-alt-2","bx bx-gas-pump","bx bx-mobile-vibration","bx bx-mobile-landscape","bx bx-border-all","bx bx-border-bottom","bx bx-border-top","bx bx-border-left","bx bx-border-right","bx bx-dialpad-alt","bx bx-filter-alt","bx bx-brightness","bx bx-brightness-half","bx bx-wifi-off","bx bx-credit-card-alt","bx bx-band-aid","bx bx-hive","bx bx-map-pin","bx bx-line-chart","bx bx-receipt","bx bx-purchase-tag-alt","bx bx-basket","bx bx-palette","bx bx-no-entry","bx bx-message-alt-dots","bx bx-message-alt","bx bx-check-square","bx bx-log-out-circle","bx bx-log-in-circle","bx bx-doughnut-chart","bx bx-building-house","bx bx-accessibility","bx bx-user-voice","bx bx-cuboid","bx bx-cube-alt","bx bx-polygon","bx bx-square-rounded","bx bx-square","bx bx-error-alt","bx bx-shield-alt-2","bx bx-paint-roll","bx bx-droplet","bx bx-street-view","bx bx-plus-medical","bx bx-search-alt-2","bx bx-bowling-ball","bx bx-dna","bx bx-cycling","bx bx-shape-circle","bx bx-down-arrow-alt","bx bx-up-arrow-alt","bx bx-right-arrow-alt","bx bx-left-arrow-alt","bx bx-lock-open-alt","bx bx-lock-alt","bx bx-cylinder","bx bx-pyramid","bx bx-comment-dots","bx bx-comment","bx bx-landscape","bx bx-book-open","bx bx-transfer-alt","bx bx-copy-alt","bx bx-run","bx bx-user-pin","bx bx-grid","bx bx-code-alt","bx bx-mail-send","bx bx-ghost"];
    @endphp


    <div class="modal fade" id="{{$control_id}}_icon-selector-modal" tabindex="-2" aria-labelledby="{{$control_id}}_icon-selector-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="{{$control_id}}_icon-selector-modal-label">Icon Selector</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="{{$control_id}}_error_div_icon-selector" class="alert alert-danger" role="alert">
                        <span id="{{$control_id}}_error_msg_icon-selector"></span>
                    </div>
                    
                        {!! csrf_field() !!}

                        <input id="{{$control_id}}_icon-selector_artifactable_id" type="hidden" value=""/>
                        <input id="{{$control_id}}_icon-selector_artifactable_class" type="hidden" value=""/>
                        <input id="{{$control_id}}_icon-selector_artifactable_name" type="hidden" value=""/>

                        <div class="card m-0 p-0">
                            <div class="card-body m-0 p-1">
                                <ul class="nav nav-tabs nav-primary" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#line_icons" role="tab" aria-selected="true">
                                            <div class="d-flex align-items-center">
                                                <div class="tab-title">Line Icons</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#bx_icons" role="tab" aria-selected="false">
                                            <div class="d-flex align-items-center">
                                                <div class="tab-title">Box Icons</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#fa_icons" role="tab" aria-selected="false">
                                            <div class="d-flex align-items-center">
                                                <div class="tab-title">Font Awesome</div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="line_icons" role="tabpanel">
                                        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-5 g-3">
                                            <div class="col">
                                                <div class="d-flex align-items-center theme-icons shadow-sm p-3 cursor-pointer rounded">
                                                    <input id="{{$control_id}}_li_iconZero" name="{{$control_id}}_selected_icon" type="radio" value="" />
                                                    <div class="ms-2">None</div>
                                                </div>
                                            </div>
                                            @foreach($li_icons as $idx=>$icon)
                                            <div class="col">
                                                <div class="d-flex align-items-center theme-icons shadow-sm p-2 cursor-pointer rounded">
                                                    <input id="{{$control_id}}_li_icon{{$idx}}" name="{{$control_id}}_selected_icon" type="radio" value="{{$icon}}" />
                                                    <div class="ms-2 font-22"><i class="{{$icon}}"></i></div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="bx_icons" role="tabpanel">
                                        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-5 g-3">
                                            <div class="col">
                                                <div class="d-flex align-items-center theme-icons shadow-sm p-3 cursor-pointer rounded">
                                                    <input id="{{$control_id}}_bx_iconZero" name="{{$control_id}}_selected_icon" type="radio" value="" />
                                                    <div class="ms-2">None</div>
                                                </div>
                                            </div>
                                            @foreach($bx_icons as $idx=>$icon)
                                            <div class="col">
                                                <div class="d-flex align-items-center theme-icons shadow-sm p-2 cursor-pointer rounded">
                                                    <input id="{{$control_id}}_bx_icon{{$idx}}" name="{{$control_id}}_selected_icon" type="radio" value="{{$icon}}" />
                                                    <div class="ms-2 font-22"><i class="{{$icon}}"></i></div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="fa_icons" role="tabpanel">
                                        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-5 g-3">
                                            <div class="col">
                                                <div class="d-flex align-items-center theme-icons shadow-sm p-3 cursor-pointer rounded">
                                                    <input id="{{$control_id}}_fa_iconZero" name="{{$control_id}}_selected_icon" type="radio" value="" />
                                                    <div class="ms-2">None</div>
                                                </div>
                                            </div>
                                            @foreach($fa_icons as $idx=>$icon)
                                            <div class="col">
                                                <div class="d-flex align-items-center theme-icons shadow-sm p-2 cursor-pointer rounded">
                                                    <input id="{{$control_id}}_fa_icon{{$idx}}" name="{{$control_id}}_selected_icon" type="radio" value="{{$icon}}" />
                                                    <div class="ms-2 font-22"><i class="{{$icon}}"></i></div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="{{$control_id}}_btn-add-icon-selector" value="add">
                        <span id="{{$control_id}}_spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span class="visually-hidden">Loading...</span>Save
                    </button>
                </div>
            </div>
        </div>
    </div>


    @push('page_scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            $('#{{$control_id}}_btn-add-icon-selector span').hide();
            $('.btn-show-icon-selector-upload').click(function(e){
                $('#{{$control_id}}_error_div_icon-selector').hide();
                $('#{{$control_id}}_icon-selector-modal').modal('show');

                $('#{{$control_id}}_icon-selector_artifactable_id').val($(this).attr('data-val-artifactable-id'));
                $('#{{$control_id}}_icon-selector_artifactable_name').val($(this).attr('data-val-artifactable-name'));
                $('#{{$control_id}}_icon-selector_artifactable_class').val($(this).attr('data-val-artifactable-class'));
            });

            $("#{{$control_id}}_btn-add-icon-selector").click(function(e){
                $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('input[name="_token"]').val()}});
                e.preventDefault();

                $('#{{$control_id}}_btn-add-icon-selector span').show();
                $('#{{$control_id}}_btn-add-icon-selector').attr('disabled',true);

                var formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                @if (isset($organization) && $organization!=null)
                    formData.append('organization_id', '{{$organization->id}}');
                @endif
                formData.append('artifactable_type', String.raw`{{get_class($artifactable)}}`);
                formData.append('artifactable_id', $('#{{$control_id}}_icon-selector_artifactable_id').val());
                formData.append('key', $('#{{$control_id}}_icon-selector_artifactable_name').val());
                formData.append('value', $('input[name="{{$control_id}}_selected_icon"]:checked').val());

                $.ajax({
                    url: "{{ route('fc-api.attributes.store') }}",
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(data){
                        if(data.success == false){
                            $('#{{$control_id}}_error_div_icon-selector').show();
                            $.each(result.errors, function(key, value){
                                $('#{{$control_id}}_error_msg_icon-selector').append('<li class="">'+value+'</li>');
                            });

                            $('#{{$control_id}}_btn-add-icon-selector span').hide();
                            $('#{{$control_id}}_btn-add-icon-selector').attr('disabled',false);
                            
                        }else{
                             swal({
                                title: "Saved",
                                text: "Icon Selected",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "OK",
                                closeOnConfirm: false
                            });
                            window.setTimeout(function(){location.reload(true);}, 1000);
                        }
                    },
                    error: function(data){
                        $('#{{$control_id}}_btn-add-icon-selector span').hide();
                        $('#{{$control_id}}_btn-add-icon-selector').attr('disabled',false);
                        console.log(data);
                    }
                });
            });

        });
    </script>
    @endpush

@endif