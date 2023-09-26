describe('Download quote', () => {
    it('should download quote', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/quotes')
        cy.get('div[id="quote_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/quotes/')
        cy.wait(1000)
        cy.get('button[id="download_quote_button"').click()
        cy.wait(5000)
        cy.verifyDownload('.pdf', { contains: true })
    })
})
