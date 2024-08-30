import "./index.scss"
import {useSelect} from "@wordpress/data"
import {useState, useEffect} from "react"
import apiFetch from "@wordpress/api-fetch"

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
  const [thePreview, setThePreview] = useState("")

  useEffect(() => {
    async function go() {
      const response = await apiFetch({
        path: `featuredAuthor/v1/getHTML?userId=${props.attributes.userId}`,
        method: "GET"
      })
      setThePreview(response)
    }
    go()
  }, [props.attributes.userId])

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
      <div dangerouslySetInnerHTML={{__html: thePreview}}></div>
    </div>
  )
}