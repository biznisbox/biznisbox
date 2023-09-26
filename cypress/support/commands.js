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
            expect(resp.body).to.have.property('data')
            cy.setCookie('token', resp.body.data)
        })
    })
})
