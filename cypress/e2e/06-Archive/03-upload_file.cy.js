describe('Upload file', () => {
    it('should upload file', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/archive')
        cy.get('div[id="header"] button[id="new_document_button"]').click()
        cy.get('div[id="upload_document_dialog"]').should('be.visible')
        cy.get('div[id="file_uploader"] input[type="file"]').selectFile('cypress/fixtures/upload/lorem.pdf', { force: true })
        cy.get('div[id="file_uploader"] button').eq(0).click()
        cy.wait(5000) // wait for upload
        cy.get('div[id="documents_table"] table tbody tr').should('contain', 'lorem.pdf')
    })
})
