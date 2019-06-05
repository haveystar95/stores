let config = {
    env: 'development',
    http: {
        defaultRequest: {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        }
    },
    language: process.env.MIX_LANGUAGE || 'eesti keel',
    debug: true
};

module.exports = Object.assign(config, window.Laravel.config);
