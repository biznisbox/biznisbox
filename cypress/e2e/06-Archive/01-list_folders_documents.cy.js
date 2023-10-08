describe('List folders and documents', () => {
    it('should check if root folder is visible', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/archive')
        cy.get('div[id="folder_tree"]').should('be.visible')
        cy.get('div[id="folder_tree"] li').should('contain', '/') // root folder should be visible
    })

    it('should check if root folder is clickable', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/archive')
        cy.get('div[id="folder_tree"] li').eq(0).click()
        cy.url().should('be.equal', Cypress.config().baseUrl + '/archive')
    })

    it('should check if documents table is visible', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/archive')
        cy.get('div[id="files_section"] table').should('be.visible')
    })
})
