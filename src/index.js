import "./index.scss"
import {useSelect} from "@wordpress/data"

wp.blocks.registerBlockType("ourplugin/featured-author", {
  title: "Author Callout",
  description: "Include a short description and link to a author of your choice",
  icon: "welcome-learn-more",
  category: "common",
  attributes: {
    authorId: {type: "string"}
  },
  edit: EditComponent,
  save: function () {
    return null
  }
})

function EditComponent(props) {
  const allAuthors = useSelect(select => {
    return select("core").getEntityRecords("root", "user", {per_page: -1})
  })

  console.log(allAuthors)

  if(allAuthors == undefined) return <p>Loading...</p>

  return (
    <div className="featured-author-wrapper">
      <div className="author-select-container">
        <select onChange={e => props.setAttributes({authorId: e.target.value})}>
          <option value="">Select an author</option>
          {allAuthors.map(author => {
            return(
            <option value={author.id} selected={props.attributes.authorId == author.id}>
              {author.nickname}
            </option>
          )
          })}
        </select>
      </div>
      <div>
        The HTML preview of the selected author will appear here.
      </div>
    </div>
  )
}