import { configureStore } from '@reduxjs/toolkit';
import reducer from '../Redux/reducers';
import {thunk} from "redux-thunk";

const store = configureStore({
  reducer: reducer,
  middleware: (getDefaultMiddleware) =>
      getDefaultMiddleware({
        serializableCheck: false,
      }).concat(thunk),
})

export default store;