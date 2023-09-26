describe('Share invoice', () => {
    it('should share invoice', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/invoices')
        cy.get('div[id="invoice_table"] table tbody tr').not('tr[class="p-datatable-emptymessage"]').first().dblclick()
        cy.url().should('include', '/invoices/')
        cy.wait(1000)
        cy.get('button[id="share_invoice_button"').click()
        cy.get('div[id="share_dialog_content"]').should('be.visible')
        cy.get('div[id="share_dialog_content"] input').type('{selectall}{ctrl+c}')
        cy.get('div[id="share_dialog_content"] button').should('be.visible')
        cy.get('div[id="share_dialog_content"] button').click()
    })
})
