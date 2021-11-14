module.exports = {
  siteMetadata: {
    title: `eProcurement Solution for Businesses | Office Supplies | Kobster`,
    description: `B2B Procurement | e-Procurement and e-Purchasing Tool | Kobster Elite - Kobster.com`,
    siteUrl: `https://www.kobster.com`
  },
  plugins: [

    `gatsby-plugin-react-helmet`,
    `gatsby-plugin-remove-serviceworker`,
    {
      resolve: `gatsby-plugin-sass`,
      options: {
        precision: 5,
      },
    },
    {
      resolve: 'gatsby-plugin-web-font-loader',
      options: {
        google: {
          families: ['Roboto', 'Open Sans']
        }
      }
    },
    {
      resolve: `gatsby-plugin-manifest`,
      options: {
        name: `kobster E shop pvt ltd`,
        short_name: `kobster.com`,
        description: `B2B Procurement | e-Procurement and e-Purchasing Tool | Kobster Elite - Kobster.com`,
        start_url: `/home/`,
        background_color: `#fff`,
        theme_color: `#db3235`,
        // Enables "Add to Homescreen" prompt and disables browser UI (including back button)
        // see https://developers.google.com/web/fundamentals/web-app-manifest/#display
        display: `standalone`,
        icon: `./src/icon.png`, // This path is relative to the root of the site.
        include_favicon: true, // Include favicon
      },
    },
    {
        resolve: `gatsby-plugin-layout`,
        options: {
            component: require.resolve(`./src/components/layout.js`)
        }
    }
  ],
  pathPrefix: `/home`,
}