Cypress.Commands.add('login', (email, password) => {
    cy.session([email, password], () => {
        cy.request({
            method: 'POST',
            url: '/api/auth/login',
            form: true,
            body: {
                email: email,
                password: password,
            },
        }).then((resp) => {
            expect(resp.status).to.eq(200)
            window.sessionStorage.setItem('token', resp.body.data)
        })
    })
})
