describe('Delete quote', () => {
    it('should delete quote', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/quotes')
        cy.get('div[id="quote_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/quotes/')
        cy.wait(1000)
        cy.get('button[id="delete_quote_button"').click()
        cy.get('div.p-dialog div.p-dialog-footer button').eq(1).click()
        cy.url().should('be.equal', Cypress.config().baseUrl + '/quotes')
    })
})
