export default {
    template: `
        <div class="container">
            <h2>Rsyslog Web Application</h2>
            <p>
                Web Application for Rsyslog on Symfony + Vue.js.
                <br>
                See on <a href="https://github.com/qbbr/rsyslog-web-app" rel="external">GitHub</a>.
            </p>

            <h3>
                Info
                <div v-if="loading" class="spinner-border spinner-border-sm align-middle text-warning" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </h3>
            <p>
                Vue.js: {{ info.vue.ver }}<br>
                OS: {{ info.os }}<br>
                PHP: {{ info.php.ver }}<br>
                Symfony: {{ info.sf.ver }} ({{ info.sf.env }})<br>
                Database: {{ info.db.ver }} ({{ info.db.size }} Mb)
            </p>

            <h3>Search</h3>

            <p>
                Default search by <b>message</b> and you can apply filters.
                <br><br>
                Available filters <em>(supports multiple)</em>:

                <ul>
                    <li><code>host</code> (alias <code>h</code>)</li>
                    <li><code>facility</code> (alias <code>f</code>)</li>
                    <li><code>tag</code> (alias <code>t</code>)</li>
                    <li><code>priority</code> (alias <code>p</code>)</li>
                </ul>

                Examples:
                <ul>
                    <li><code>tag = "kernel:"</code></li>
                    <li><code>host != "SRV-1", p = "info"</code></li>
                    <li><code>host="SRV-2, DNSSEC"</code> (can be multiple)</li>
                    <li><code>h="ROUTER-2", f!="auth",p="error"</code></li>
                </ul>
            </p>

            <h3>Hotkeys</h3>

            <ul>
                <li><kbd>/</kbd>, <kbd>s</kbd> - focus the search bar</li>
                <li><kbd>Ctrl + ArrowRight</kbd> - goto the next page</li>
                <li><kbd>Ctrl + ArrowLeft</kbd> - goto the previous page</li>
                <li><kbd>Ctrl + Shift + ArrowRight</kbd> - goto the last page</li>
                <li><kbd>Ctrl + Shift + ArrowLeft</kbd> - goto the first page</li>
                <li><kbd>Click(filter link)</kbd> - filter <code>=</code></li>
                <li><kbd>RightClick(filter link)</kbd> - exclude filter <code>!=</code></li>
                <li><kbd>Ctrl + Click(filter link)</kbd> - multiple select/toggle filter <code>=</code></li>
                <li><kbd>Ctrl + RightClick(filter link)</kbd> - multiple select/toggle exclude filter <code>!=</code></li>
            </ul>

            <hr>

            <span class="text-muted">
                Build and run tested on <b>amd64</b> and <b>aarch64</b> (rpi3b).
                <br>
                Developed with &lt;3 by <a href="https://qbbr.cat" rel="external">@qbbr</a>.
            </span>
        </div>
    `,
    data() {
        return {
            loading: true,
            info: {
                vue: { ver: Vue.version },
                os: '...',
                php: { ver: '...' },
                sf: { ver: '...', env: '...' },
                db: { ver: '...', size: '...' },
            }
        }
    },
    mounted() {
        this.getInfo();
    },
    methods: {
        getInfo() {
            this.loading = true;
            this.$http.get('/info').then(response => {
                this.info = Object.assign(this.info, response.data);
                this.loading = false;
            });
        }
    }
}
