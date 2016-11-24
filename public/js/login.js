;(function () {
    const login = () => {
        const refreshPage = () => {
            window.location.reload();
        };

        const loginWithSiteCredentials = (e) => {
            const currentPageUrl = window.document.URL;
            const win = window.open(`/login?intended-url=${currentPageUrl}`, "site-login", 'width=800, height=600');

            const pollTimer = window.setInterval(function () {
                try {
                    console.log(win.document.URL);
                    if (win.document.URL === currentPageUrl) {
                        window.clearInterval(pollTimer);
                        win.close();
                        refreshPage();
                    }
                } catch (e) {
                }
            }, 500);
        };

        return {
            handle(){
                console.log('hey');
                $('a#site-login').on('click', loginWithSiteCredentials);
            }
        }
    };

    login().handle();
}());

//# sourceMappingURL=login.js.map
