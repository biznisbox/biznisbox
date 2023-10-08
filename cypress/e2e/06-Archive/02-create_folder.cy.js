import { faker } from '@faker-js/faker'
describe('Create folder', () => {
    it('should create folder', () => {
        cy.login(Cypress.env('USERNAME'), Cypress.env('PASSWORD'))
        cy.visit('/archive')
        cy.get('div[id="header"] button[id="new_folder_button"]').click()
        cy.get('input[id="folder_name_input"]').should('be.visible')
        let folderName = faker.lorem.slug()
        cy.get('input[id="folder_name_input"]').type(folderName)
        cy.get('button[id="save_folder_button"]').click()
        cy.get('div[id="folder_tree"] li').should('include.text', folderName)
    })
})
