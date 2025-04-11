import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import $ from 'jquery';
window.jQuery = window.$ = $;

/**
 *  Swiper -
 */
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

/* To use Autoplay, Pagination and navigation */
Swiper.use([Autoplay, Pagination]);

const multiSwiper = new Swiper('.multi-swiper', {
    pagination: {
        el: ".swiper-pagination",
        type: "progressbar",
    },
    slidesPerView: 12,
    spaceBetween: 0,
    // autoplay: {
    //     delay: 2500,
    //     disableOnInteraction: false
    // },
    breakpoints: {
        320: {
            slidesPerView: 6,
            spaceBetweenSlides: 16
        },
        480: {
            slidesPerView: 6,
            spaceBetweenSlides: 16
        },
        800: {
            slidesPerView: 6,
            spaceBetweenSlides: 16
        },
        1000: {
            slidesPerView: 8,
            spaceBetweenSlides: 16
        },
        1200: {
            slidesPerView: 8,
            spaceBetweenSlides: 16
        },
        1400: {
            slidesPerView: $(".total-days").length,
            spaceBetweenSlides: 16
        }
    }
});

// import 'jquery-ui/ui/widgets/button'; // Import specific widgets as needed
// import 'jquery-ui/ui/widgets/dialog';  // Example for dialog
// import 'jquery-ui/ui/widgets/tabs';    // Example for tabs

// import 'jquery-ui/ui/widgets/datepicker';
// import 'jquery-ui/themes/base/theme.css'; // Optional: Include jQuery UI CSS


