describe('Delete product', () => {
    it('should delete product', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/products')
        cy.get('div[id="products_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/products/')
        cy.get('div[id="header"] div div button').eq(1).click()
        cy.get('div.p-dialog div.p-dialog-footer button').eq(1).click()
        cy.url().should('be.equal', Cypress.config().baseUrl + '/products')
    })
})
