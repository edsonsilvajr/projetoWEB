import React from 'react'
import { useRouteMatch } from 'react-router'

interface Params {
  title: string
}

function Recipe() {
  const { params } = useRouteMatch<Params>()
  return <div>oi</div>
}

export default Recipe
