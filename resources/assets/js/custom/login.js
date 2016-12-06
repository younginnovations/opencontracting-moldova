(function () {
    const login = () => {
        const refreshPage = () => {
            window.location.reload();
        };

        const handleLoginInNewWindow = redirectUrl => {
            const currentPageUrl = window.document.URL;
            const win = window.open(`${redirectUrl}?intended-url=${currentPageUrl}`, "Social Login", 'width=800, height=600');

            const pollTimer = window.setInterval(function () {
                try {
                    console.log(win.document.URL.replace(/[^A-Za-z0-9: \.\/]/g,''));
                    if (win.document.URL.replace(/[^A-Za-z0-9: \.\/]/g,'') === currentPageUrl) {
                        window.clearInterval(pollTimer);
                        win.close();
                        refreshPage();
                    }
                } catch (e) {
                }
            }, 500);
        };

        const loginWithFacebook = e => {
            handleLoginInNewWindow('/social/redirect/facebook');
        };

        const loginWithGoogle = e => {
            handleLoginInNewWindow('/social/redirect/google')
        };

        return {
            handle(){
                $('a.facebook-login').on('click', loginWithFacebook);
                $('a.google-login').on('click', loginWithGoogle);
            }
        }
    };

    login().handle();
}());
