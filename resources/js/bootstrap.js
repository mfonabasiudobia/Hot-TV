/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    forceTLS: false,
    encrypted: true,
    enabledTransports: ['ws', 'wss'],
});

console.log("Hostname", window.location.hostname);
console.log("Worign!")

//Subscribe to orders channel and listen for NewOrder events
// window.Echo.channel(`public.test.1`)
//     .subscribed(() => {
//         console.log("Echo connected to PieSocket channel!");
//     })
//     .listen('.test', (data) => {
//         alert("New Order Received");
//         console.log("New Order Data", data);
//     });
import Swal from 'sweetalert2';
const jobProgressToasts = {};

window.Echo.private('job-progress.1')
    .subscribed(() => {
        console.log("Echo connected to job-progress channel!");
    })
    .listen('.job-progress', (event) => {
        if (!jobProgressToasts[event.jobId]) {
            jobProgressToasts[event.jobId] = Swal.fire({
                title: `Job ${event.title} is at ${event.progress}% progress.`,
                html: '<b>Progress:</b><br><div id="progress-bar-container"></div>',
                timer: 0,
                showCancelButton: false,
                showConfirmButton: false,
                position: 'bottom-end',
                didOpen: () => {
                    const progressBarContainer = document.getElementById('progress-bar-container');
                    progressBarContainer.innerHTML = `
                        <progress id="job-progress" value="${event.progress}" max="100"></progress>
                    `;
                },
                willClose: () => {
                    document.getElementById('job-progress').remove();
                }
            });
        } else {
            jobProgressToasts[event.jobId].update({
                title: `Job #${event.jobId} is at ${event.progress}% progress.`,
                html: '<b>Progress:</b><br><div id="progress-bar-container"></div>',
            });
            const progressBarContainer = document.getElementById('progress-bar-container');
            progressBarContainer.innerHTML = `
                <progress id="job-progress" value="${event.progress}" max="100"></progress>
            `;
            // const progressBar = document.getElementById('job-progress');
            // progressBar.value = event.progress;
        }

        if (event.progress === 100) {
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: `Job #${event.jobId} is complete!`,
                    text: 'Congratulations on completing the job.',
                    showConfirmButton: false,
                    timer: 1000
                });

                jobProgressToasts[event.jobId] = null;
            }, 10000);
        }
    });


// wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
