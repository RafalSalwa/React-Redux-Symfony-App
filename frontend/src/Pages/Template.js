import { Fragment } from "react";
import Header from "../Components/Header";

const Template = (props) => {
  return (
    <Fragment>
      <Header />
      <div className="content-container">
        {props.children}
      </div>
    </Fragment>
  );
};

export default Template;