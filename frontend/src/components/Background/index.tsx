import React, { ReactElement } from 'react'
import './styles.scss'

interface Props {
  children: ReactElement
  background?: string
}

function Background({ children, background = 'background-default' }: Props) {
  return <div className={`${background}`}>{children}</div>
}

export default Background
