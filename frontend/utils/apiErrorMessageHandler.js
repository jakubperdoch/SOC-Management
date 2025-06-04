const apiErrorMessageHandler = (error) => {
  const response = error.response;

  const errorValues = Object.values(response._data?.errors ?? {});

  const errorMap = errorValues.flatMap((error) => error);

  console.log(errorMap);
  return errorMap.join("\n");
};

export default apiErrorMessageHandler;
